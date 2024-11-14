<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\ChangeOrderStatusRequest;
use App\Http\Requests\Orders\PlaceOrderRequest;
use App\Http\Responses\Response;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function checkout(Request $request)
    {
        $data = [];
        try{
            $shipping_address = $request->input('Shipping_Address');
            $data = $this->orderService->checkout($request);
            return response()->json([
                'addresses' => $data['addresses'],
                'products' => $data['products'],
                'shipping methods' => $data['shipping_methods'],
                'payment methods' => $data['payment_methods'],
                'wallet points' => $data['wallet_points'] ,
                'message' => $data['message']
            ]);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function place_order(PlaceOrderRequest $request)
    {
        try {
            $data = $this->orderService->place_order($request);
            return Response::Success($data['order'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error([],$message);
        }
    }

    public function cancel_placed_order($order_id)
    {
        $data = [];
        try {
            $data = $this->orderService->cancel_placed_order($order_id);
            return Response::Success($data['order'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function change_order_status($order_id,ChangeOrderStatusRequest $request)
    {
        $data = [];
        try {
            $data = $this->orderService->change_order_status($order_id , $request->validated());
            return response()->json([
                'order' => $data['order'],
                'status' => $data['status'],
                'message' => $data['message'],

            ]);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
}
