<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Http\Requests\categoryRequest;
use App\Http\Responses\Response;
use App\Repositories\categories\CategoryRepositoryInterface;
use Exception;
=======
use App\Http\Requests\Categories\categoryRequest;
use App\Http\Responses\Response;
use App\Repositories\categories\CategoryRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

<<<<<<< HEAD
    public function GetAllCategories()
    {
        $data = [];
        try {
            $data = $this->categoryRepository->all();
=======
    public function show_all_categories():JsonResponse
    {
        $data = [];
        try {
            $data = $this->categoryRepository->show_all_categories();
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['categories'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

<<<<<<< HEAD
    public function GetOneCategory($id)
    {
        $data = [];
        try {
            $data = $this->categoryRepository->find($id);
=======
    public function show_category($category_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->categoryRepository->show_category($category_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

<<<<<<< HEAD
    public function CreateCategory(categoryRequest $request)
    {
        $data = [];
        try {
            $data = $this->categoryRepository->create($request->validated());
=======
    public function create_category(categoryRequest $request):JsonResponse
    {
        $data = [];
        try {
            $data = $this->categoryRepository->create_category($request->validated());
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

<<<<<<< HEAD
    public function UpdateCategory(categoryRequest $request, $id)
    {
        $data = [];
        try {
            $data = $this->categoryRepository->update($id,$request->validated());
=======
    public function update_category(categoryRequest $request, $category_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->categoryRepository->update_category($category_id,$request->validated());
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

<<<<<<< HEAD
    public function DestroyCategory($id)
    {
        $data = [];
        try {
            $data = $this->categoryRepository->delete($id);
=======
    public function delete_category($category_id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->categoryRepository->delete_category($category_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
<<<<<<< HEAD
    public function SearchCategory(Request $request)
=======
    public function search_by_category(Request $request):JsonResponse
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        $data = [];
        $query = $request->input('query');
        try {
<<<<<<< HEAD
            $data = $this->categoryRepository->searchCategory($query);
=======
            $data = $this->categoryRepository->search_by_category($query);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            return Response::Success($data['categories'], $data['message']);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }
}
