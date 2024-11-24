<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Http\Requests\Address\CreateAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Responses\Response;
use App\Services\OrderService;
use Exception;
=======
use App\Http\Requests\Orders\ChangeOrderStatusRequest;
use App\Http\Requests\Orders\PlaceOrderRequest;
use App\Http\Responses\Response;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8

class OrderController extends Controller
{
    public $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
<<<<<<< HEAD
    public function save_address(CreateAddressRequest $request)
    {
        $data = [];
        try{
            $data = $this->orderService->save_address($request->validated());
            return Response::Success($data['address'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function make_primary($address_id)
    {
        $data = [];
        try{
            $data = $this->orderService->make_primary($address_id);
            return Response::Success($data['new_primary'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
//    public function show_addresses()
//    {
//        $data = [];
//        try{
//            $data = $this->orderService->show_addresses();
//            return Response::Success($data['addresses'] , $data['message']);
//        }catch(Exception $e){
//            $message  = $e->getMessage();
//            return Response::Error($data,$message);
//        }
//    }
    public function edit_address($address_id,UpdateAddressRequest $request)
    {
        $data = [];
        try{
            $data = $this->orderService->edit_address($address_id,$request->validated());
            return Response::Success($data['address'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete_address($address_id)
    {
        $data = [];
        try{
            $data = $this->orderService->delete_address($address_id);
            return Response::Success($data['address'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function deliver_to_my_address($cart_id)
    {
        $data = [];
        try{
            $data = $this->orderService->deliver_to_my_address($cart_id);
            return response()->json([
                'addresses' => $data['addresses'],
                'products' => $data['products'],
                'shipping_methods' => $data['shipping_methods'],
                'payment_methods' => $data['payment_methods'],
=======

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
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
                'message' => $data['message']
            ]);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
<<<<<<< HEAD
=======

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
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
}
