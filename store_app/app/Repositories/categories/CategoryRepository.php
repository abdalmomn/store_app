<?php

namespace App\Repositories\categories;

use App\Models\Category;
use App\Repositories\categories\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class CategoryRepository implements CategoryRepositoryInterface
{
<<<<<<< HEAD
    public function all()
=======
    public function show_all_categories():array
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
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

<<<<<<< HEAD
    public function find($id){
       $category=Category::find($id);
=======
    public function show_category($category_id):array
    {
       $category=Category::find($category_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
       $category ? $message = 'getting category successfully' : $message = 'not found';
       return [
           'category' => $category,
           'message' => $message
       ];
    }

<<<<<<< HEAD
    public function create(array $attributes)
=======
    public function create_category(array $attributes):array
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
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

<<<<<<< HEAD
    public function update($id, array $attributes)
    {

        $category =category::find($id);
=======
    public function update_category($category_id, array $attributes):array
    {
        $category =category::find($category_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
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

<<<<<<< HEAD
    public function delete($id)
    {
            $category = Category::find($id);
=======
    public function delete_category($category_id):array
    {
            $category = Category::find($category_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
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

<<<<<<< HEAD
    public function searchCategory($query)
=======
    public function search_by_category($query):array
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
            $categories = category::where('name', 'like', "%{$query}%")->get();
            $categories ? $message = 'getting categories' : $message = 'there is no result';
            return [
                'categories' => $categories,
                'message' => $message
            ];
    }
}
