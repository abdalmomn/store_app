<?php

namespace App\Repositories\categories;

interface CategoryRepositoryInterface
{
<<<<<<< HEAD
    public function all();
    public function find($id);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function delete($id);
    public function searchCategory($query);
=======
    public function show_all_categories();
    public function show_category($category_id);
    public function create_category(array $attributes);
    public function update_category($category_id, array $attributes);
    public function delete_category($category_id);
    public function search_by_category($query);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8

}
