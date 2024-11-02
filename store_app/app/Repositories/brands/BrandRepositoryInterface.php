<?php

namespace App\Repositories\brands;

interface BrandRepositoryInterface
{
    public function show_all_brands();
    public function show_brand($brand_id);
    public function create_brand(array $attributes);
    public function update_brand($brand_id, array $attributes);
    public function delete_brand($brand_id);
    public function search_by_brand($query);
    public function get_brands_by_category($category_id);
}
