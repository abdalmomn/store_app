<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\Response;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Repositories\products\ProductRepository;
use App\Repositories\products\ProductRepositoryInterface;
class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function index()
    {
        $data = [];
        try{
           $data = $this->productRepository->all();
           return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
           $message = $e->getMessage();
           return Response::Error($data,$message);
        }
    }
    public function create(ProductRequest $request)
    {
        $data = [];
        try{
            $data = $this->productRepository->create($request->validated());
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }


    public function show($id)
    {
        $data = [];
        try{
            $data = $this->productRepository->find($id);
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }



    public function update(ProductRequest $request, $id)
    {
        $data = [];
        try{
            $data = $this->productRepository->update($id,$request->validated());
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
     }


    public function destroy($id)
    {
        $data = [];
        try{
            $data = $this->productRepository->delete($id);
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function getByCategory($categoryId)
    {
        $data = [];
        try{
            $data = $this->productRepository->getProductsByCategory($categoryId);
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
      }
    public function getByBrand($brandId)
    {
        $data = [];
        try{
            $data = $this->productRepository->getProductsByBrand($brandId);
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
      }
    public function getProductsByCategoryAndBrand($categoryId,$brandId=null)
    {
        $data = [];
        try{
            $data = $this->productRepository->getProductsByCategoryAndBrand($categoryId,$brandId);
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
      }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $data = [];
        try{
            $data = $this->productRepository->searchProducts($query);
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
     }

    public function getPopular($limit = 5)
    {
        $data = [];
        try{
            $data = $this->productRepository->getPopularProducts($limit);
            return Response::Success($data['products'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
}
