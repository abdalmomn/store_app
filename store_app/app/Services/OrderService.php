<?php
namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Status;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService{


    //to show the place order page information
    public function checkout($request)
    {
        //handle the gps location

        //there are two sections to order
        if ($request->shipping_address == 'Deliver to my address') {
            //show the address immediately because there is at least one address before go to place order page
            $addresses = Address::query()
                ->where('user_id', Auth::id())
                ->orderBy('primary', 'desc')
                ->get();

            $shipping_method = ['local_delivery', 'external_delivery'];
        }elseif ($request->shipping_address == 'I will pick it up myself'){
            $addresses = null;
            $shipping_method = null;
        }else{
            $addresses = null;
            $shipping_method = null;
        }

        //show cart products
        $cart_items = Cart::with(['products' => function ($query){
            $query->select('cart_items.*');
        }])
            ->where('user_id', Auth::id())
            ->first();

        $payment_method = ['card' , 'cash_on_delivery' , 'points_system'];
        $points = Wallet::query()->where('user_id', Auth::id())->first();//show the current points for this user

        $addresses || $payment_method  ? $message = 'getting all data successfully' : $message = 'not found';

        return [
            'addresses' => $addresses,
            'products' => $cart_items,
            'shipping_methods' => $shipping_method,
            'payment_methods' => $payment_method,
            'wallet_points' => $points->balance,
            'message' => $message
        ];
    }

    public function place_order($request)
    {
        return DB::transaction(function () use ($request) {
            $status = Status::query()
                ->where('status' , '=' ,'pending')
                ->first();

            $address = Address::query()
                ->where('primary', 1)
                ->where('user_id', Auth::id()) // Ensure it's the user's address
                ->first();

            $cart = Cart::query()
                ->where('user_id', Auth::id())
                ->with('products') // Get products with pivot data (price, quantity)
                ->first();

            if (!$cart || $cart->products->isEmpty()) {
                return [
                    'order' => null,
                    'message' => 'your cart is empty'
                ];
            }

            $total_price = $cart->total_price;

            //handle if there is more than shipping method
            //handle shipping cost if changeable
            //I prefer that the cost is fixed because there is point_system, usually user have a certain points
            $shipping_cost = $address->country == 'UAE' ? 10 : 20;
            $shipping_method = $address->country == 'UAE' ? 'local - {shipping method name}' : 'external - {shipping method name}';

            $payment_method = $request['payment_method'];

            $coupon = null;
            if (!empty($request['coupon_code'])) {
                // Check if coupon exists and is valid
                $coupon = Coupon::query()
                    ->where('code', $request['coupon_code'])
                    ->where('expires_in', '>=', now()) // Ensure the coupon is not expired
                    ->first();

                if (!$coupon) {
                    return [
                        'order' => null,
                        'message' => 'Invalid or expired coupon.'
                    ];
                }

                //Check coupon usage limit
                if ($coupon->usage_count >= $coupon->usage_limit) {
                    return [
                        'order' => null,
                        'message' => 'Coupon usage limit reached.'
                    ];
                }

                // Apply coupon discount
                $total_price -= ($total_price * ($coupon->discount_percentage * 0.01));
            }
            $wallet = Wallet::query()
                ->where('user_id', Auth::id())
                ->first();
            if ($payment_method == 'points_system' && $wallet->balance >= $total_price){
                return [
                    'order' => null,
                    'message' => 'you do not have enough points for this process',
                ];
            }
            $total_price += $shipping_cost; // add shipping cost to the total price

            // Generate the trading order reference
            $latestId = Order::max('id') ?? 0; // Get the latest ID or 0 if no records exist
            $orderReference = 'ORDER-' . now()->format('Ymd') . '-' . str_pad($latestId + 1, 6, '0', STR_PAD_LEFT);

            $order = Order::query()->create([
                'order_reference' => $orderReference,
                'user_id' => Auth::id(),
                'status_id' => $status->id,
                'coupon_id' => $coupon?->id,
                'address_id' => $address->id ? $address->id : null,
                'shipping_method' => $shipping_method,
                'payment_method' => $payment_method,
                'shipping_cost' => $shipping_cost,
                'total_price' => $total_price
            ]);
            $message = 'order placed successfully';

            $coupon?->increment('usage_count');//check if the coupon exist and increment the usage count field

            foreach ($cart->products as $cart_item) {
                // Attach new product to order
                $order->products()->attach($cart_item->id, [
                    'quantity' => $cart_item->pivot->quantity,
                    'total_price' => $cart_item->pivot->price,
                ]);
            }

            $cart->products()->detach(); //delete pivot table items
            $cart->update([
                'total_price' => 0,
                'updated_at' => now(),
            ]);

            return [
                'order' => $order,
                'message' => $message,
            ];
        });
        }

    public function cancel_placed_order($order_id)
    {
        return DB::transaction(function () use ($order_id) {
            $order = Order::query()
                ->where('id' , $order_id)
                ->where('user_id' , Auth::id())
                ->with('products')
                ->first();

            $order_status = Status::query()->find($order->status_id);

            $canceled_status = Status::query()
                ->where('status' , 'canceled')
                ->first();

            if ($order_status->status == 'pending'){ // cancel only and only if the order status is pending
                $order->status_id = $canceled_status->id;
                $order->products()->detach(); // delete pivot table items
                $order->save();

                $message = 'order canceled successfully';
            }else{
                $order = null;
                $message = 'you can not cancel the order in this status';
            }
            return [
                'order' => $order,
                'message' => $message
            ];
        });
    }

    //handle notification in this method
    public function change_order_status($order_id,$request)
    {
        return DB::transaction(function () use ($order_id, $request) {
            //only admin can change the status
            if (Auth::user()->hasRole('admin')){
                $order = Order::query()
                    ->where('id' , $order_id)
                    ->with('products')
                    ->first();
                $status = Status::query()
                    ->where('status' , $request['status'])
                    ->first();
                //admin update the status
                $order->update([
                    'status_id' => $status->id,
                ]);
                $order->save();

                if ($order->payment_method == 'points_system') { //only for points system, I do not handle other methods

                    // when the status changed to preparing the points will deduct from the wallet and points will add to referral client
                    if ($status->status == 'preparing' ) {
                        //notification to user that payment is done
                        $user = User::query()->find($order->user_id);
                        $wallet = Wallet::query()
                            ->where('user_id', $order->user_id)
                            ->first();



                        if ($wallet->balance >= $order->total_price) {
                            $wallet->decrement('balance', $order->total_price);

                            Transaction::query()->create([
                                'type' => 'points deduction',
                                'amount' => $order->total_price,
                                'wallet_id' => $wallet->id,
                                'order_id' => $order_id,
                            ]);
                            if ($user->referred_by_code) {
                                $referrer = User::query()
                                    ->where('referral_code', $user->referred_by_code)
                                    ->first();
                                if ($referrer) {
                                    $referrer_wallet = Wallet::query()
                                        ->where('user_id', $referrer->id)
                                        ->first();
                                    $added_points = $order->total_price * 0.01; // add points to referrer
                                    $referrer_wallet->increment('balance', $added_points);

                                    Transaction::query()->create([
                                        'type' => 'points addition',
                                        'amount' => $added_points,
                                        'wallet_id' => $referrer_wallet->id,
                                        'order_id' => $order_id,
                                    ]);
                                }
                            }
                        } else {
                            //notification that doesn't have enough points
                            $canceled_status = Status::query()
                                ->where('status', '=', 'canceled')
                                ->first();
                            $order->update([
                                'status_id' => $canceled_status->id,
                            ]);

                            $order->products()->detach(); // if the order canceled then deleted pivot table items

                            return [
                                'order' => $order,
                                'status' => $canceled_status,
                                'message' => 'send notification. there is no enough points'
                            ];
                        }
                    }
                }
                $message = 'status changed successfully';
            }else{
                $order = null;
                $status = null;
                $message = 'unauthenticated';
            }
            return [
                'order' => $order,
                'status' => $status,
                'message' => $message
            ];
        });
        }

}



