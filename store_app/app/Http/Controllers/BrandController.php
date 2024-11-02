<?php

namespace App\Http\Controllers;
use App\Http\Requests\Brands\BrandRequest;
use App\Http\Responses\Response;
use App\Repositories\brands\BrandRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $BrandRepository;

    public function __construct(BrandRepositoryInterface $BrandRepository)
    {
        $this->BrandRepository = $BrandRepository;
    }

    public function show_all_brands(Request $request):JsonResponse
    {
        $data = [];
        try {
            $data = $this->BrandRepository->show_all_brands();
            return Response::Success($data['brands'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function show_brand($brand_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->BrandRepository->show_brand($brand_id);
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }



    public function create_brand(BrandRequest $request):JsonResponse
    {
        $data = [];
        try {
            $data = $this->BrandRepository->create_brand($request->validated());
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }



    public function update_brand(BrandRequest $request, $brand_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->BrandRepository->update_brand($brand_id,$request->validated());
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function delete_brand($brand_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->BrandRepository->delete_brand($brand_id);
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function search_by_brand(Request $request):JsonResponse
    {
        $data = [];
        try {
            $query = $request->input('query');
            $data = $this->BrandRepository->search_by_brand($query);
            return Response::Success($data['brands'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
     }
     public function get_brands_by_category($category_id):JsonResponse
     {
         $data = [];
         try {
             $data = $this->BrandRepository->get_brands_by_category($category_id);
             return Response::Success($data['brands'],$data['message']);
         }catch (Exception $e){
             $message = $e->getMessage();
             return Response::Error($data,$message);
         }
    }
}
