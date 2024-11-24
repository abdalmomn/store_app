<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\categoryRequest;
use App\Http\Responses\Response;
use App\Repositories\categories\CategoryRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function show_all_categories():JsonResponse
    {
        $data = [];
        try {
            $data = $this->categoryRepository->show_all_categories();
            return Response::Success($data['categories'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function show_category($category_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->categoryRepository->show_category($category_id);
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function create_category(categoryRequest $request):JsonResponse
    {
        $data = [];
        try {
            $data = $this->categoryRepository->create_category($request->validated());
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function update_category(categoryRequest $request, $category_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->categoryRepository->update_category($category_id,$request->validated());
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function delete_category($category_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->categoryRepository->delete_category($category_id);
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function search_by_category(Request $request):JsonResponse
    {
        $data = [];
        $query = $request->input('query');
        try {
            $data = $this->categoryRepository->search_by_category($query);
            return Response::Success($data['categories'], $data['message']);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }
}
