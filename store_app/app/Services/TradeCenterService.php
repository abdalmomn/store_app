<?php
namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use App\Models\TradeCenter;
use Illuminate\Support\Facades\Auth;

class TradeCenterService{
    public function show_trade_page($request)
    {
        // Fetch all categories for the user to select from
        $categories = Category::all();

        // Fetch all brands to be used for optional filtering
        $brands = Brand::all();

        // Fetch the user's selected category and brand (if any)
        $selectedCategory = $request['category_id'];
        $selectedBrand = $request['brand_id'] ?? null;

        // Build the query to get products based on user selection
        $query = Product::query();

        // Filter products by category if one is selected
        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory);
        }

        // Further filter by brand if one is selected
        if ($selectedBrand) {
            $query->where('brand_id', $selectedBrand);
        }

        // Get the filtered products
        $products = $query->get();

        $message = 'Products fetched successfully';

        // Return the categories, brands, and products to the view or API response
        return [
            'products' => $products,
            'message' => $message,
        ];
    }


    public function trade_product($request)
    {
        $status = Status::query()
            ->where('status','=','pending')
            ->first();

        // Generate the trading order reference
        $latestId = TradeCenter::max('id') ?? 0; // Get the latest ID or 0 if no records exist
        $orderReference = 'TRADE-' . now()->format('Ymd') . '-' . str_pad($latestId + 1, 6, '0', STR_PAD_LEFT);

        $request['trading_order_reference'] = $orderReference;
        $request['user_id'] = Auth::id();
        $request['status_id'] = $status->id;

        $product = TradeCenter::query()->create($request);
        $message = 'creating trade product successfully';
        return [
            'product' => $product,
            'message' => $message
        ];
    }

    public function edit_trade_product($trade_id,$request)
    {
        $trade_product = TradeCenter::query()
            ->where('user_id',Auth::id())
            ->where('id' , $trade_id)
            ->first();
        $status = Status::query()
            ->where('id',$trade_product->id)
            ->first();
        if ($trade_product){
            if ($status->status == 'pending'){
                $trade_product->update($request);
                $trade_product = TradeCenter::query()->find($trade_id);
                $message = 'edit trading product successfully';
            }else{
                $message = 'can not edit trade product in this status';
            }
        }else{
            $trade_product = null;
            $message = 'trade product not found';
        }

        return [
            'product' => $trade_product,
            'message' => $message
        ];
    }

    public function change_trade_status($request,$trade_id)
    {
        if (Auth::user()->hasRole('admin')){
            $trade_product = TradeCenter::query()
                ->where('id' , $trade_id)
                ->first();
            $status = Status::query()
                ->where('status' , $request['status'])
                ->first();
            if ($trade_product) {
                $trade_product->update([
                    'status_id' => $status->id
                ]);
                if ($request['status'] == 'accepted'){
                    $trade_product->approximate_price = $request['approximate_price'];
                    //notification to user that status accepted
                }
                //notification to user that status rejected

                $message = 'status changed successfully';
            }else{
                $trade_product = null;
                $message = 'trade product not found';
            }
        }else{
            $trade_product = null;
            $message = 'unauthenticated';
        }
        return [
            'product' => $trade_product,
            'message' => $message
        ];
    }

    public function cancel_trade_product($trade_id)
    {
        $trade_product = TradeCenter::query()
            ->where('id' , $trade_id)
            ->first();
        $status = Status::all();
        $pending_status = $status->where('status' , '=' , 'pending')->first();
        if ($trade_product->status_id == $pending_status->id) {
            $cancel_status = $status->where('status' , '=' , 'canceled')->first();
            $trade_product->status_id =  $cancel_status->id;
            $trade_product->save();
            $message = 'trading canceled';
        }else{
            $message = 'you can not cancel the order in this status';
        }
        return [
            'product' => $trade_product,
            'message' => $message
        ];
    }
}
