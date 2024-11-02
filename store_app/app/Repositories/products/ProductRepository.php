<?php

namespace App\Repositories\products;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\products\ProductRepositoryInterface;


class ProductRepository implements ProductRepositoryInterface
{
    public function show_all_products():array
    {
        $products = product::query()
            ->select()
            ->paginate(50);
        $products ? $message = 'getting all products successfully' : $message = 'not found';

        return [
            'products' => $products,
            'message' => $message,
        ];
    }

    public function show_product($product_id):array
    {

        $product = Product::find($product_id);
        $product ? $message = 'getting product successfully' : $message = 'not found';
        return [
            'product' => $product,
            'message' => $message,
        ];
    }

    public function create_product(array $attributes):array
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

    public function update_product($product_id, array $attributes):array
    {
        $product = product::find($product_id);

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

    public function delete_product($product_id):array
    {
        $product = Product::find($product_id);
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


    public function get_products_by_category($category_id):array
    {
        $products = Product::where('category_id', $category_id)->get();
        $products ? $message = 'getting products successfully' : $message = 'there are no products for this category';
        return [
            'products' => $products,
            'message' => $message,
        ];
    }

    public function get_products_by_brand($brand_id):array
    {
        $products = Product::where('brand_id', $brand_id)->get();
        $products ? $message = 'getting products successfully' : $message = 'there are no products for this brand';
        return [
            'products' => $products,
            'message' => $message,
        ];
    }

    public function search_products($query):array
    {
        $products = Product::where('name', 'like', "%{$query}%")->get();
        $products ? $message = 'getting products successfully' : $message = 'no results';
        return [
            'products' => $products,
            'message' => $message,
        ];
    }

// تحتاج للتعديل
    public function get_popular_products($limit = 5):array
    {
        return Product::orderBy('quantity', 'desc')->take($limit)->get();
    }

    public function get_products_by_category_and_brand($category_id, $brand_id = null):array
    {
            $query = Product::where('category_id', $category_id);

            if ($brand_id) {
                $query->where('brand_id', $brand_id);
            }

            $products = $query->get();

            $products ? $message = 'getting products successfully' : $message = 'there are no products for this section';
            return [
                'products' => $products,
                'message' => $message,
            ];
    }
}
