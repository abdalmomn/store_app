<?php

namespace App\Repositories\products;

interface ProductRepositoryInterface
{
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
}
