<?php

namespace App\Repositories\products;

interface ProductRepositoryInterface
{
<<<<<<< HEAD
    public function all();
    public function find($id);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function delete($id);
    public function getProductsByCategoryAndBrand($brandId);
    public function getProductsByBrand($brandId);
    public function getProductsByCategory($categoryId);
    public function searchProducts($query);
    public function getPopularProducts($limit = 5);
=======
    public function show_all_products();
    public function show_product($product_id);
    public function create_product(array $attributes);
    public function update_product($product_id, array $attributes);
    public function delete_product($product_id);
    public function get_products_by_category_and_brand($category_id);
    public function get_products_by_brand($brand_id);
    public function get_products_by_category($category_id);
    public function search_products($query);
    public function get_popular_products($limit = 5);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
}
