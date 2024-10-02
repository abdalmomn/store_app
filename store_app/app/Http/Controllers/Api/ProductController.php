<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Repositories\products\ProductRepository;
use App\Repositories\products\ProductRepositoryInterface;
class ProductController extends Controller
{
    protected $ProductRepository;
    public function __construct(ProductRepositoryInterface $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }


    public function index()
    {
       return $this->ProductRepository->all();
    }
    public function create(ProductRequest $request)
    {
        return$this->ProductRepository->create($request->validated());
    }


    public function show($id)
    {
        return$this->ProductRepository->find($id);
    }



    public function update(ProductRequest $request, $id)
    {
        return$this->ProductRepository->update($id, $request->validated());
     }


    public function destroy($id)
    {
        return  $this->ProductRepository->delete($id);
       }
    public function getByCategory($categoryId)
    {
        return  $this->ProductRepository->getProductsByCategory($categoryId);
      }
    public function getByBrand($brandId)
    {
        return  $this->ProductRepository->getProductsByBrand($brandId);
      }
    public function getProductsByCategoryAndBrand($categoryId,$brandId=null)
    {
        return  $this->ProductRepository->getProductsByCategoryAndBrand($categoryId,$brandId);
      }

    public function search(Request $request)
    {
        $query = $request->input('query');
        return $this->ProductRepository->searchProducts($query);
     }

    public function getPopular($limit = 5)
    {
        return $this->ProductRepository->getPopularProducts($limit);
    }
}
