<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Http\Requests\AddToCartRequest;
=======
use App\Http\Requests\Carts\AddToCartRequest;
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
use App\Http\Responses\Response;
use App\Services\CartService;
use Exception;
use Illuminate\Http\JsonResponse;
<<<<<<< HEAD
use Illuminate\Http\Request;
=======
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8

class CartController extends Controller
{
    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function show_cart():jsonResponse
    {
        $data = [];
        try {
            $data = $this->cartService->show_cart();
            return Response::Success($data['cart'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function add_to_cart(AddToCartRequest $request,$product_id):jsonResponse
    {
        $data = [];
        try {
            $data = $this->cartService->add_to_cart($request->validated(),$product_id);
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete_from_cart($product_id):jsonResponse
    {
        $data = [];
        try {
            $data = $this->cartService->delete_from_cart($product_id);
            return Response::Success($data['cart'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
<<<<<<< HEAD

    ////
    // add update quantity to cart

=======
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
}
