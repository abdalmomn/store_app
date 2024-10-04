<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\categoryRequest;
use App\Http\Responses\Response;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\categories\CategoryRepositoryInterface;
use App\Repositories\categories\CategoryRepository;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $data = [];
        try {
            $data = $this->categoryRepository->all();
            return Response::Success($data['categories'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function show($id)
    {
        $data = [];
        try {
            $data = $this->categoryRepository->find($id);
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function create(categoryRequest $request)
    {
        $data = [];
        try {
            $data = $this->categoryRepository->create($request->validated());
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function update(categoryRequest $request, $id)
    {
        $data = [];
        try {
            $data = $this->categoryRepository->update($id,$request->validated());
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function destroy($id)
    {
        $data = [];
        try {
            $data = $this->categoryRepository->delete($id);
            return Response::Success($data['category'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function search(Request $request)
    {
        $data = [];
        $query = $request->input('query');
        try {
            $data = $this->categoryRepository->searchCategory($query);
            return Response::Success($data['categories'], $data['message']);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }
}
