<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\categoryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\categories\CategoryRepositoryInterface;
use App\Repositories\categories\CategoryRepository;

class CategoryController extends Controller
{
    protected $CategoryRepository;

    public function __construct(CategoryRepositoryInterface $CategoryRepository)
    {
        $this->CategoryRepository = $CategoryRepository;
    }

    public function index()
    {
        return  $this->CategoryRepository->all();
    }

    public function show($id)
    {
        return  $this->CategoryRepository->find($id);
    }



    public function create(categoryRequest $request)
    {
        return $this->CategoryRepository->create($request->validated());
    }

    public function update(categoryRequest $request, $id)
    {
        return $this->CategoryRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return$this->CategoryRepository->delete($id);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        return $this->CategoryRepository->searchCategory($query);    }

}
