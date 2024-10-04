<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Http\Requests\BrandRequest;
use App\Http\Responses\Response;
use App\Repositories\brands\BrandRepositoryInterface;
use App\Repositories\brands\BrandRepository;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    protected $BrandRepository;
    public function __construct(BrandRepositoryInterface $BrandRepository)
    {
        $this->BrandRepository = $BrandRepository;
    }

    public function index(Request $request)
    {
        $data = [];
        try {
            $data = $this->BrandRepository->all();
            return Response::Success($data['brands'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function show($id)
    {
        $data = [];
        try {
            $data = $this->BrandRepository->find($id);
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }



    public function create(BrandRequest $request)
    {
        $data = [];
        try {
            $data = $this->BrandRepository->create($request->validated());
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }



    public function update(BrandRequest $request, $id)
    {
        $data = [];
        try {
            $data = $this->BrandRepository->update($id,$request->validated());
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function destroy($id)
    {
        $data = [];
        try {
            $data = $this->BrandRepository->delete($id);
            return Response::Success($data['brand'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function search(Request $request)
    {
        $data = [];
        try {
            $query = $request->input('query');
            $data = $this->BrandRepository->searchBrand($query);
            return Response::Success($data['brands'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
     }
     public function getByCategory($categoryId)
     {
         $data = [];
         try {
             $data = $this->BrandRepository->getBrandByCategory($categoryId);
             return Response::Success($data['brands'],$data['message']);
         }catch (Exception $e){
             $message = $e->getMessage();
             return Response::Error($data,$message);
         }
    }
}
