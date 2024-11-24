<?php
namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
<<<<<<< HEAD
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderService{

    /*
     * 1-deliver to my address
     * information:
     * country , full name , phone , city , street name , building name , apartment name
     * 2- make more than one address to the user and save it in the table, the address can edit, delete and make primary location
     * 3- add payment method:
     * information:
     * card number , expires date , CVV , name on card
     * 4-there are chooses to the payment method
     * use valid credit card
     * credit card , pay on delivery
     * 5- there is coupon discount
     * 5-there are order summary with subtotal price for each product and total price for all and the price after coupon discount.
     * 6-place the order in the all tables and show order with the status
     * 7- the statuses can be updated by admin
     */
    /*
     * 2-pick it up myself
     * information:
     * the store location , full name , phone number
     * also payment methods
     * use valid credit card
     */


    public function save_address($request)
    {
        $primary = Address::query()->where('user_id' , Auth::id())
            ->where('primary' , '=' , 1)
            ->first();

        $request['user_id'] = Auth::id();
        $address = Address::query()->create($request);
        if (!$primary){
            $address['primary'] = 1;
            $address->save();
        }else {
            $address['primary'] = 0;
            $address->save();
        }
        return [
            'address' => $address,
            'message' => 'address saved successfully',
        ];
    }

//    public function show_addresses()
//    {
//        $addresses = Address::query()
//            ->where('user_id',Auth::id())
//            ->orderBy('primary' , 'desc')
//            ->get();
//        if ($addresses){
//            $message = 'getting addresses successfully';
//        }else{
//            $addresses = null;
//            $message = 'not found';
//        }
//        return [
//            'addresses' => $addresses,
//            'message' => $message
//        ];
//    }

    public function make_primary($address_id)
    {
        $new_primary = Address::query()
            ->where('user_id' , Auth::id())
            ->where('id' , $address_id)
            ->first();
        if ($new_primary){
            $current_primary = Address::query()
            ->where('user_id' , Auth::id())
            ->where('primary' , '=' , 1)
            ->first();
            if ($current_primary){
                $current_primary->primary = 0;
                $current_primary->save();
            }
            $new_primary->primary = 1;
            $new_primary->save();
            $message = 'primary address switched successfully';
        }else{
            $new_primary = null;
            $message = 'not found';
        }

        return [
            'new_primary' => $new_primary,
            'message' => $message
        ];

    }
    public function edit_address($address_id,$request)
    {
        $address = Address::query()
            ->where('id' , $address_id)
            ->update($request);
        $address = Address::find($address_id);
        return [
            'address' => $address,
            'message' => 'address updated successfully'
        ];
    }
    public function delete_address($address_id)
    {
        $address = Address::query()
            ->where('id' , $address_id)
            ->delete();
        return [
            'address' => '',
            'message' => 'address deleted successfully'
        ];
    }

    public function deliver_to_my_address($cart_id)
    {
        //show the address immediately because there is at least one address before go to place order page
        $addresses = Address::query()
            ->where('user_id',Auth::id())
            ->orderBy('primary' , 'desc')
            ->get();

=======
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
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        $cart_items = Cart::with(['products' => function ($query){
            $query->select('cart_items.*');
        }])
            ->where('user_id', Auth::id())
            ->first();
<<<<<<< HEAD
        $cart_items->products()
            ->where('cart_items.cart_id' , $cart_id)
            ->get();

        //$shipping_methods will be local or external delivery
        $shipping_method = 'local delivery';

        $payment_method = PaymentMethod::all();
=======

        $payment_method = ['card' , 'cash_on_delivery' , 'points_system'];
        $points = Wallet::query()->where('user_id', Auth::id())->first();//show the current points for this user
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8

        $addresses || $payment_method  ? $message = 'getting all data successfully' : $message = 'not found';

        return [
            'addresses' => $addresses,
            'products' => $cart_items,
            'shipping_methods' => $shipping_method,
            'payment_methods' => $payment_method,
<<<<<<< HEAD
=======
            'wallet_points' => $points->balance,
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            'message' => $message
        ];
    }

    public function place_order($request)
    {
<<<<<<< HEAD
        //handle payment methods
        //if($payment_method == ''){
        //}
    }
}


/*
 * shipping system:
 * shipping method : internal => if the country = UAE , external otherwise
 * shipping cost input by admin
 *
 * */
=======
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



>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
