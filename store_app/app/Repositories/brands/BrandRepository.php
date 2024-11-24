<?php

namespace App\Repositories\brands;

use App\Models\Brand;
use App\Repositories\brands\BrandRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class BrandRepository implements BrandRepositoryInterface
{
    public function show_all_brands():array
    {
        $brands = Brand::query()
        ->select('name')
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

    public function show_brand($brand_id):array
    {
            $brand = Brand::find($brand_id);
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

    public function create_brand(array $attributes):array
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

    public function update_brand($brand_id, array $attributes):array
    {
            $brand = brand::find($brand_id);

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

    public function delete_brand($brand_id):array
    {

            $brand = Brand::find($brand_id);
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
    public function search_by_brand($query):array
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
    public function get_brands_by_category($category_id):array
    {

        $brands=Brand::where('category_id', $category_id)->get();
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
