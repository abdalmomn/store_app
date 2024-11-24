<?php

namespace App\Http\Controllers;
<<<<<<< HEAD
use App\Http\Requests\BrandRequest;
use App\Http\Responses\Response;
use App\Repositories\brands\BrandRepositoryInterface;
use Exception;
=======
use App\Http\Requests\Brands\BrandRequest;
use App\Http\Responses\Response;
use App\Repositories\brands\BrandRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
use Illuminate\Http\Request;

class BrandController extends Controller
{
<<<<<<< HEAD

    protected BrandRepositoryInterface $BrandRepository;
=======
    protected $BrandRepository;

>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    public function __construct(BrandRepositoryInterface $BrandRepository)
    {
        $this->BrandRepository = $BrandRepository;
    }

<<<<<<< HEAD
    public function GetAllBrand(Request $request)
    {
        $data = [];
        try {
            $data = $this->BrandRepository->all();
=======
    public function show_all_brands(Request $request):JsonResponse
    {
        $data = [];
        try {
            $data = $this->BrandRepository->show_all_brands();
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['brands'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

<<<<<<< HEAD
    public function GetOneBrand($id)
    {
        $data = [];
        try {
            $data = $this->BrandRepository->find($id);
=======
    public function show_brand($brand_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->BrandRepository->show_brand($brand_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }



<<<<<<< HEAD
    public function CreateBrand(BrandRequest $request)
    {
        $data = [];
        try {
            $data = $this->BrandRepository->create($request->validated());
=======
    public function create_brand(BrandRequest $request):JsonResponse
    {
        $data = [];
        try {
            $data = $this->BrandRepository->create_brand($request->validated());
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }



<<<<<<< HEAD
    public function UpdateBrand(BrandRequest $request, $id)
    {
        $data = [];
        try {
            $data = $this->BrandRepository->update($id,$request->validated());
=======
    public function update_brand(BrandRequest $request, $brand_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->BrandRepository->update_brand($brand_id,$request->validated());
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

<<<<<<< HEAD
    public function DestroyBrand($id)
    {
        $data = [];
        try {
            $data = $this->BrandRepository->delete($id);
=======
    public function delete_brand($brand_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->BrandRepository->delete_brand($brand_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
<<<<<<< HEAD
    public function SearchForBrand(Request $request)
=======
    public function search_by_brand(Request $request):JsonResponse
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        $data = [];
        try {
            $query = $request->input('query');
<<<<<<< HEAD
            $data = $this->BrandRepository->searchBrand($query);
=======
            $data = $this->BrandRepository->search_by_brand($query);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['brands'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
     }
<<<<<<< HEAD
     public function GetBrandByCategory($categoryId)
     {
         $data = [];
         try {
             $data = $this->BrandRepository->getBrandByCategory($categoryId);
=======
     public function get_brands_by_category($category_id):JsonResponse
     {
         $data = [];
         try {
             $data = $this->BrandRepository->get_brands_by_category($category_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
             return Response::Success($data['brands'],$data['message']);
         }catch (Exception $e){
             $message = $e->getMessage();
             return Response::Error($data,$message);
         }
    }
}
