<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Http\Requests\ProductRequest;
use App\Http\Responses\Response;
use App\Repositories\products\ProductRepositoryInterface;
use Exception;
=======
use App\Http\Requests\products\ProductRequest;
use App\Http\Responses\Response;
use App\Repositories\products\ProductRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
use Illuminate\Http\Request;

class ProductController extends Controller
{
<<<<<<< HEAD
    protected ProductRepositoryInterface $productRepository;
=======
    protected $productRepository;

>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }


<<<<<<< HEAD
    public function GetAllProducts()
    {
        $data = [];
        try{
           $data = $this->productRepository->all();
=======
    public function show_all_products():JsonResponse
    {
        $data = [];
        try{
           $data = $this->productRepository->show_all_products();
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
           return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
           $message = $e->getMessage();
           return Response::Error($data,$message);
        }
    }
<<<<<<< HEAD
    public function CreateProduct(ProductRequest $request)
    {
        $data = [];
        try{
            $data = $this->productRepository->create($request->validated());
=======
    public function create_product(ProductRequest $request):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->create_product($request->validated());
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }


<<<<<<< HEAD
    public function GetOneProduct($id)
    {
        $data = [];
        try{
            $data = $this->productRepository->find($id);
=======
    public function show_product($product_id):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->show_product($product_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }



<<<<<<< HEAD
    public function UpdateProduct(ProductRequest $request, $id)
    {
        $data = [];
        try{
            $data = $this->productRepository->update($id,$request->validated());
=======
    public function update_product(ProductRequest $request, $product_id):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->update_product($product_id,$request->validated());
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
     }


<<<<<<< HEAD
    public function DestroyProduct($id)
    {
        $data = [];
        try{
            $data = $this->productRepository->delete($id);
=======
    public function delete_product($product_id):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->delete_product($product_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
<<<<<<< HEAD
    public function getByCategory($categoryId)
    {
        $data = [];
        try{
            $data = $this->productRepository->getProductsByCategory($categoryId);
=======
    public function get_products_by_category($category_id):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->get_products_by_category($category_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
      }
<<<<<<< HEAD
    public function getByBrand($brandId)
    {
        $data = [];
        try{
            $data = $this->productRepository->getProductsByBrand($brandId);
=======
    public function get_products_by_brand($brand_id):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->get_products_by_brand($brand_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
      }
<<<<<<< HEAD
    public function GetProductsByCategoryAndBrand($categoryId,$brandId=null)
    {
        $data = [];
        try{
            $data = $this->productRepository->getProductsByCategoryAndBrand($categoryId,$brandId);
=======
    public function get_products_by_category_and_brand($category_id,$brand_id=null):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->get_products_by_category_and_brand($category_id,$brand_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
      }

<<<<<<< HEAD
    public function SearchProduct(Request $request)
=======
    public function search_products(Request $request):JsonResponse
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        $query = $request->input('query');
        $data = [];
        try{
<<<<<<< HEAD
            $data = $this->productRepository->searchProducts($query);
=======
            $data = $this->productRepository->search_products($query);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
     }

<<<<<<< HEAD
    public function GetPapular($limit = 5)
    {
        $data = [];
        try{
            $data = $this->productRepository->getPopularProducts($limit);
=======
    public function get_popular_products($limit = 5):JsonResponse
    {
        $data = [];
        try{
            $data = $this->productRepository->get_popular_products($limit);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
}
