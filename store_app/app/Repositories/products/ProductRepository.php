<?php

namespace App\Repositories\products;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\products\ProductRepositoryInterface;


class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        try{
            $product = product::query()
            ->select()
            ->paginate(50);
            if ($product->isEmpty()) {
                return response()->json(['message' => 'No products found'], 200);
            }
            return [
                'product' => $product,
                'message' => "success!",
            ];            }catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while fetching product'], 500);
            }
    }

    public function find($id)
    {try{
        $Product= Product::find($id);
            if (!$Product) {
             return response()->json(['message' => ' Product not found'], 200);
         }
         return response()->json(['success'=>true,'data'=>$Product,'message'=>"get successful!"], 200);
     }   catch (\Exception $e) {
       return response()->json(['error' => 'An error occurred while fetching the Product'], 500);
   }
    }

    public function create(array $attributes)
    {
        try {
            $Product =  Product::create($attributes);
            return response()->json(['success'=>true,'data'=>$Product,'message'=>"created successful!"], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the Product'], 400);
        }
    }

    public function update($id, array $attributes)
    {
        try {
            $product = product::find($id);
            if (!$product) {
                return response()->json(['error' => 'product not found'], 404);
            }
            $product->update($attributes);
            return response()->json(['success'=>true,'data'=>$product,'message'=>"update successful!"], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the product'], 500);
        }
    }

    public function delete($id)
    {  try {
            $Product = Product::find($id);
                if ($Product==false) {
                    return response()->json(['error' => 'Product not found'], 404);
                }

                $Product->delete();
                return response()->json(['message' => 'Product deleted successfully'], 200);
            } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the Product'], 500);
        }

    }


    public function getProductsByCategory($categoryId)
    {  try{
        $Product=Product::where('category_id', $categoryId)->get();
        if ($Product->isEmpty()) {
            return response()->json(['message' => 'there isnt any products whith this category '], 200);
        }
          return response()->json($Product, 200);
    }catch(\Exception $e){
        return response()->json(['error' => 'An error occurred while getProductsByCategory '], 500);

    }
    }
    public function getProductsByBrand($brandId)
    {  try{
        $Product=Product::where('brand_id', $brandId)->get();
        if ($Product->isEmpty()) {
            return response()->json(['message' => 'there isnt any products whith this brand '], 200);
        }
          return response()->json($Product, 200);
    }catch(\Exception $e){
        return response()->json(['error' => 'An error occurred while getProducts '], 500);

    }
    }

    public function searchProducts($query)
    {
        try{
            $Product=Product::where('name', 'like', "%{$query}%")->get();
            if ($Product->isEmpty()) {
                return response()->json(['message' => 'no result found '], 200);
            }
              return response()->json(['success'=>true,'data'=>$Product,'message'=>"search successful!"], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'An error occurred while do search '], 500);

        }
    }
// تحتاج للتعديل
    public function getPopularProducts($limit = 5)
    {
        return Product::orderBy('quantity', 'desc')->take($limit)->get();
    }

    public function getProductsByCategoryAndBrand($categoryId, $brandId = null)
{
    try {
        $query = Product::where('category_id', $categoryId);

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'there isnt any products whith this information '], 200);
        }
        return response()->json(['success'=>true,'data' => $products,'message'=>"get successful!"], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while getProducts'], 500);
    }
}

}
