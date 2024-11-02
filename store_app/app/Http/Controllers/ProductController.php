<?php

namespace App\Http\Controllers;

use App\Http\Requests\products\ProductRequest;
use App\Http\Responses\Response;
use App\Repositories\products\ProductRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function show_all_products():JsonResponse
    {
        $data = [];
        try{
           $data = $this->productRepository->show_all_products();
           return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
           $message = $e->getMessage();
           return Response::Error($data,$message);
        }
    }
    public function create_product(ProductRequest $request):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->create_product($request->validated());
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }


    public function show_product($product_id):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->show_product($product_id);
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }



    public function update_product(ProductRequest $request, $product_id):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->update_product($product_id,$request->validated());
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
     }


    public function delete_product($product_id):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->delete_product($product_id);
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function get_products_by_category($category_id):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->get_products_by_category($category_id);
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
      }
    public function get_products_by_brand($brand_id):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->get_products_by_brand($brand_id);
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
      }
    public function get_products_by_category_and_brand($category_id,$brand_id=null):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->get_products_by_category_and_brand($category_id,$brand_id);
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
      }

    public function search_products(Request $request):JsonResponse
    {
        $query = $request->input('query');
        $data = [];
        try{
            $data = $this->productRepository->search_products($query);
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
     }

    public function get_popular_products($limit = 5):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->get_popular_products($limit);
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
}
