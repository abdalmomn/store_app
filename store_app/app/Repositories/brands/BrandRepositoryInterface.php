<?php

namespace App\Repositories\brands;

interface BrandRepositoryInterface
{
<<<<<<< HEAD
    public function all();
    public function find($id);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function delete($id);
    public function searchBrand($id);
    public function getBrandByCategory($id);
=======
    public function show_all_brands();
    public function show_brand($brand_id);
    public function create_brand(array $attributes);
    public function update_brand($brand_id, array $attributes);
    public function delete_brand($brand_id);
    public function search_by_brand($query);
    public function get_brands_by_category($category_id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
}
