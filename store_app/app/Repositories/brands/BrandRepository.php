<?php

namespace App\Repositories\brands;

use App\Models\Brand;
use App\Repositories\brands\BrandRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class BrandRepository implements BrandRepositoryInterface
{
<<<<<<< HEAD
    public function all()
    {
        $brands = Brand::query()
        ->select("name")
=======
    public function show_all_brands():array
    {
        $brands = Brand::query()
        ->select('name')
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        ->paginate(50);
        if ($brands->isEmpty()) {
            $message = 'not found';
        }else{
            $message = 'getting brands successfully';
        }
        return [
            'brands' => $brands,
            'message' => $message
        ];
    }

<<<<<<< HEAD
    public function find($id)
    {
            $brand = Brand::find($id);
=======
    public function show_brand($brand_id):array
    {
            $brand = Brand::find($brand_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            if (!$brand) {
                $message = 'not found';
            }else{
                $message = 'getting brand successfully';
            }
            return [
                'brand' => $brand,
                'message' => $message
            ];
    }

<<<<<<< HEAD
    public function create(array $attributes)
=======
    public function create_brand(array $attributes):array
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        if (Auth::user()->hasRole('admin')){
            $brand = Brand::create($attributes);
            $message = 'brand created successfully';
        }else{
            $brand = null;
            $message = 'you do not have access';
        }
        return [
            'brand' => $brand,
            'message' => $message,
        ];
    }

<<<<<<< HEAD
    public function update($id, array $attributes)
    {
            $brand = brand::find($id);
=======
    public function update_brand($brand_id, array $attributes):array
    {
            $brand = brand::find($brand_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8

            if ($brand) {
                if (Auth::user()->hasRole('admin')) {
                    $message = 'brand updated successfully';
                    $brand->update($attributes);
                }else{
                    $brand = null;
                    $message = 'you do not have access';
                }
            }else {
                $message = 'not found';
            }
        return [
            'brand' => $brand,
            'message' => $message
        ];
    }

<<<<<<< HEAD
    public function delete($id)
    {

            $brand = Brand::find($id);
=======
    public function delete_brand($brand_id):array
    {

            $brand = Brand::find($brand_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            if ($brand) {
                if (Auth::user()->hasRole('admin')) {
                    $brand->delete();
                    $message = 'brand deleted successfully';
                }else{
                    $brand = null;
                    $message = 'you co not have access';
                }
            }else {
                    $message = 'not found';
                }
            return [
                'brand' => $brand,
                'message' => $message
            ];
    }
<<<<<<< HEAD
    public function searchBrand($query)
=======
    public function search_by_brand($query):array
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
            $brands=Brand::where('name', 'like', "%{$query}%")->get();
            if ($brands->isEmpty()) {
                $message = 'no result';
            }else{
                $message = 'getting successfully';
            }
            return [
                'brands' => $brands,
                'message' => $message
            ];
    }
<<<<<<< HEAD
    public function getBrandByCategory($categoryId){

        $brands=Brand::where('category_id', $categoryId)->get();
=======
    public function get_brands_by_category($category_id):array
    {

        $brands=Brand::where('category_id', $category_id)->get();
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        if ($brands->isEmpty()) {
            $message = 'there is no brand for this category';
        }else{
            $message = 'getting brands successfully';
        }
        return [
            'brands' => $brands,
            'message' => $message
        ];
    }


}
