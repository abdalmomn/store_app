<?php

namespace App\Http\Controllers;

use App\Http\Requests\TradeCenter\InsertTradeProductRequest;
use App\Http\Requests\TradeCenter\ShowProductPageRequest;
use App\Http\Requests\TradeCenter\UpdateTradeProductRequest;
use App\Http\Requests\TradeCenter\UpdateTradeStatusRequest;
use App\Http\Responses\Response;
use App\Services\TradeCenterService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TradeCenterController extends Controller
{
    public $tradeCenterService;

    public function __construct(TradeCenterService $tradeCenterService)
    {
        $this->tradeCenterService = $tradeCenterService;
    }

    public function show_trade_page(ShowProductPageRequest $request)
    {
        $data = [];
        try {
            $data = $this->tradeCenterService->show_trade_page($request->validated());
            return Response::Success($data['products'] , $data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function trade_product(InsertTradeProductRequest $request)
    {
        $data = [];
        try {
            $photos = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $image_path = $photo->store('images/product/repairing', 'public');

                    // Get the full URL for the stored image
                    $image_url = Storage::disk('public')->path($image_path);

                    // Push the full image URL into the photos array
                    $photos[] = $image_url;
                }
            }
            $data['photos'] = json_encode($photos); // Store the array of URLs as a JSON string

            $data['brand_id'] = $request['brand_id'] ?? null;
            $trade_product_data = array_merge($request->validated(), $data);
            $result = $this->tradeCenterService->trade_product($trade_product_data);

            return Response::Success($result['product'], $result['message']);

        }catch (Exception $e) {
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function edit_trade_product($trade_id,UpdateTradeProductRequest $request)
    {
        $photos = [];
        try {
            if ($request->hasFile('photos')){
                foreach ($request->file('photos') as $photo){
                    $image_path = $photo->store('images/product' , 'public');
                    $image_url = Storage::disk('public')->path($image_path);
                    $photos[] = $image_url;
                }
            }
            $data['photos'] = json_encode($photos);
            $trade_product_data = array_merge($request->validated(),$data);

            $result = $this->tradeCenterService->edit_trade_product($trade_product_data,$trade_id);
            return Response::Success($result['product'], $result['message']);
        }catch (Exception $e) {
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function change_trade_status(UpdateTradeStatusRequest $request,$trade_id)
    {
        $data = [];
        try {
            $data = $this->tradeCenterService->change_trade_status($request->validated(),$trade_id);
            return Response::Success($data['product'] , $data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function cancel_trade_product($trade_id)
    {
        $data = [];
        try {
            $data = $this->tradeCenterService->cancel_trade_product($trade_id);
            return Response::Success($data['product'] , $data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
}
