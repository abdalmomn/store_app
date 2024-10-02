<?php

namespace App\Repositories\categories;

use App\Models\Category;
use App\Repositories\categories\CategoryRepositoryInterface;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        try{
        $category = category::query()
        ->select("name")
        ->paginate(50);
        if ($category->isEmpty()) {
            return response()->json(['message' => 'No categories found'], 200);
        }
        return $category;
        }catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching Category'], 500);
        }
    }

    public function find($id)
    {try{
       $Category=Category::find($id);
        if (!$Category) {
            return response()->json(['message' => 'No Category found'], 200);
        }
        return response()->json(['success'=>true,'data'=>$Category,'message'=>"get successful!"], 200);
    }   catch (\Exception $e) {
      return response()->json(['error' => 'An error occurred while fetching the Category'], 500);
  }
    }

    public function create(array $attributes)
    {
        try {
            $Category =  Category::create($attributes);
            return response()->json(['success'=>true,'data'=>$Category,'message'=>"create successful!"], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the Category'], 400);
        }
    }

    public function update($id, array $attributes)
    {
        try {
            $category =category::find($id);
            if (!$category) {
                return response()->json(['error' => 'category not found'], 404);
            }
            $category->update($attributes);
            return response()->json(['success'=>true,'data'=>$category,'message'=>"update successful!"], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the Category'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $Category = Category::find($id);

            if ($Category==false) {
                return response()->json(['error' => 'Category not found'], 404);
            }

            $Category->delete();
            return response()->json(['success'=>true,'message'=>"delete successful!"], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the Category'], 500);
        }
    }

    public function searchCategory($query)
    {
        try{
            $category=category::where('name', 'like', "%{$query}%")->get();
            if ($category->isEmpty()) {
                return response()->json(['message' => 'no result found '], 200);
            }
              return response()->json(['success'=>true,'data'=>$category,'message'=>"get successful!"], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'An error occurred while do search '], 500);

        }
    }
}
