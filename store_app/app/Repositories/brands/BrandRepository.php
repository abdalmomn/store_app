<?php

namespace App\Repositories\brands;

use App\Models\Brand;
use App\Repositories\brands\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    public function all()
    {
        try{
        $Brand = Brand::query()
        ->select("name")
        ->paginate(50);
        if ($Brand->isEmpty()) {
            return response()->json(['message' => 'No brands found'], 200);
        }
        return response()->json(['success'=>true,'data'=>$Brand,'message'=>"get successful!",200]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while fetching brands'], 500);
    }

    }

    public function find($id)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                return response()->json(['error' => 'Brand not found'], 404);
            }
            return response()->json(['success'=>true,'data'=>$brand,'message'=>"get successful!"],200);
        }   catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the brand'], 500);
        }
    }

    public function create(array $attributes)
    {
        try {
            $brand = Brand::create($attributes);
            return response()->json(['success'=>true,'data'=>$brand,'message'=>"create successful!"],201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the brand'], 400);
        }    }

    public function update($id, array $attributes)
    {
        try {
            $brand = brand::find($id);
            if (!$brand) {
                return response()->json(['error' => 'Brand not found'], 404);
            }
            $brand->update($attributes);
            return response()->json(['success'=>true,'data'=>$brand,'message'=>"update successful!"],200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the brand'], 500);
        }

    }

    public function delete($id)
    {

        try {
            $brand = Brand::find($id);

            if ($brand==false) {
                return response()->json(['error' => 'Brand not found'], 404);
            }

            $brand->delete();
            return response()->json(['success'=>true,'message' => 'Brand deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the brand'], 500);
        }
    }
    public function searchBrand($query)
    {
        try{
            $Brand=Brand::where('name', 'like', "%{$query}%")->get();
            if ($Brand->isEmpty()) {
                return response()->json(['message' => 'no result found '], 200);
            }
            return response()->json(['success'=>true,'data'=>$Brand,'message'=>"get successful!"],200);
        }catch(\Exception $e){
            return response()->json(['error' => 'An error occurred while do search '], 500);

        }
    }
    public function getBrandByCategory($categoryId)
    {  try{
        $Brand=Brand::where('category_id', $categoryId)->get();
        if ($Brand->isEmpty()) {
            return response()->json(['success'=>true,'message' => 'there isnt any Brands whith this category '], 200);
        }
          return response()->json($Brand, 200);
    }catch(\Exception $e){
        return response()->json(['error' => 'An error occurred while getBrandsByCategory '], 500);

    }
    }


}
