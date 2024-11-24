<?php

namespace App\Repositories\categories;

use App\Models\Category;
use App\Repositories\categories\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class CategoryRepository implements CategoryRepositoryInterface
{
    public function show_all_categories():array
    {
        $categories = category::query()
        ->select("name")
        ->paginate(50);

        $categories ? $message = 'getting all categories successfully' : $message = 'not found';
        return [
            'categories' => $categories,
            'message' => $message
        ];
    }

    public function show_category($category_id):array
    {
       $category=Category::find($category_id);
       $category ? $message = 'getting category successfully' : $message = 'not found';
       return [
           'category' => $category,
           'message' => $message
       ];
    }

    public function create_category(array $attributes):array
    {
            if (Auth::user()->hasRole('admin')){
                $category =  Category::query()->create($attributes);
                $message = 'category created successfully';
            }else{
                $category = null;
                $message = 'you do not have access';
            }
            return [
                'category' => $category,
                'message' => $message
            ];
    }

    public function update_category($category_id, array $attributes):array
    {
        $category =category::find($category_id);
        if ($category) {
            if (Auth::user()->hasRole('admin')){
                $category->update($attributes);
                $message = 'category updated successfully';
            }else{
                $category = null;
                $message = 'you do not have access';
            }
        }else{
            $message = 'not found';
        }
        return [
            'category' => $category,
            'message' => $message
        ];
    }

    public function delete_category($category_id):array
    {
            $category = Category::find($category_id);
            if ($category) {
                if (Auth::user()->hasRole('admin')){
                    $category->delete();
                    $message = 'category deleted successfully';
                }else{
                    $category = null;
                    $message = 'you do not have access';
                }
            }else{
                $message = 'not found';
            }
            return [
                'category' => $category,
                'message' => $message
            ];
    }

    public function search_by_category($query):array
    {
            $categories = category::where('name', 'like', "%{$query}%")->get();
            $categories ? $message = 'getting categories' : $message = 'there is no result';
            return [
                'categories' => $categories,
                'message' => $message
            ];
    }
}
