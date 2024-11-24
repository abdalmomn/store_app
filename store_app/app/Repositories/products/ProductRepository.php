<?php

namespace App\Repositories\products;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\products\ProductRepositoryInterface;


class ProductRepository implements ProductRepositoryInterface
{
<<<<<<< HEAD
    public function all()
    {
        $products = product::query()
            ->select()
            ->paginate(50);
=======
    public function show_all_products():array
    {
        $products = product::query()
            ->select()
            ->cursorPaginate(25);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        $products ? $message = 'getting all products successfully' : $message = 'not found';

        return [
            'products' => $products,
            'message' => $message,
        ];
    }

<<<<<<< HEAD
    public function find($id)
    {

        $product = Product::find($id);
=======
    public function show_product($product_id):array
    {

        $product = Product::find($product_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        $product ? $message = 'getting product successfully' : $message = 'not found';
        return [
            'product' => $product,
            'message' => $message,
        ];
    }

<<<<<<< HEAD
    public function create(array $attributes)
=======
    public function create_product(array $attributes):array
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        if (Auth::user()->hasRole('admin')){
            $product = Product::create($attributes);
            $message = 'product created successfully';
        }else{
            $product = null;
            $message = 'you do not have access';
        }
        return [
            'product' => $product,
            'message' => $message,
        ];

    }

<<<<<<< HEAD
    public function update($id, array $attributes)
    {
        $product = product::find($id);
=======
    public function update_product($product_id, array $attributes):array
    {
        $product = product::find($product_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8

        if ($product) {
            if (Auth::user()->hasRole('admin')){
                $product->update($attributes);
                $message = 'product updated successfully';
            }else{
                $product = null;
                $message = 'you do not have access';
            }
        } else {
            $message = 'not found';
        }
        return [
            'product' => $product,
            'message' => $message,
        ];

    }

<<<<<<< HEAD
    public function delete($id)
    {
        $product = Product::find($id);
=======
    public function delete_product($product_id):array
    {
        $product = Product::find($product_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        if ($product) {
            if (Auth::user()->hasRole('admin')){
                $product->delete();
                $message = 'product deleted successfully';
            }else{
                $product = null;
                $message = 'you do not have access';
            }
        } else {
            $message = 'not found';
        }
        return [
            'product' => $product,
            'message' => $message,
        ];

    }


<<<<<<< HEAD
    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
=======
    public function get_products_by_category($category_id):array
    {
        $products = Product::where('category_id', $category_id)->get();
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        $products ? $message = 'getting products successfully' : $message = 'there are no products for this category';
        return [
            'products' => $products,
            'message' => $message,
        ];
    }

<<<<<<< HEAD
    public function getProductsByBrand($brandId)
    {
        $products = Product::where('brand_id', $brandId)->get();
=======
    public function get_products_by_brand($brand_id):array
    {
        $products = Product::where('brand_id', $brand_id)->get();
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        $products ? $message = 'getting products successfully' : $message = 'there are no products for this brand';
        return [
            'products' => $products,
            'message' => $message,
        ];
    }

<<<<<<< HEAD
    public function searchProducts($query)
=======
    public function search_products($query):array
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        $products = Product::where('name', 'like', "%{$query}%")->get();
        $products ? $message = 'getting products successfully' : $message = 'no results';
        return [
            'products' => $products,
            'message' => $message,
        ];
    }

// تحتاج للتعديل
<<<<<<< HEAD
    public function getPopularProducts($limit = 5)
=======
    public function get_popular_products($limit = 5):array
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        return Product::orderBy('quantity', 'desc')->take($limit)->get();
    }

<<<<<<< HEAD
    public function getProductsByCategoryAndBrand($categoryId, $brandId = null)
    {
            $query = Product::where('category_id', $categoryId);

            if ($brandId) {
                $query->where('brand_id', $brandId);
=======
    public function get_products_by_category_and_brand($category_id, $brand_id = null):array
    {
            $query = Product::where('category_id', $category_id);

            if ($brand_id) {
                $query->where('brand_id', $brand_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
            }

            $products = $query->get();

            $products ? $message = 'getting products successfully' : $message = 'there are no products for this section';
            return [
                'products' => $products,
                'message' => $message,
            ];
    }
}
