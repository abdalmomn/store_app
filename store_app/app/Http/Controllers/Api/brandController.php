<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Http\Requests\BrandRequest;
use App\Repositories\brands\BrandRepositoryInterface;
use App\Repositories\brands\BrandRepository;
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
        return $this->BrandRepository->all();
    }

    public function show($id)
    {
        return $this->BrandRepository->find($id);
    }



    public function create(BrandRequest $request)
    {
        return $this->BrandRepository->create($request->validated());
    }



    public function update(BrandRequest $request, $id)
    {
        return $this->BrandRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return  $this->BrandRepository->delete($id);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        return $this->BrandRepository->searchBrand($query);
     }
     public function getByCategory($categoryId)
     {
         return  $this->BrandRepository->getBrandByCategory($categoryId);
       }
}
