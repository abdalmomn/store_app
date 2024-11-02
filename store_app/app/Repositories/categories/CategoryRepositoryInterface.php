<?php

namespace App\Repositories\categories;

interface CategoryRepositoryInterface
{
    public function show_all_categories();
    public function show_category($category_id);
    public function create_category(array $attributes);
    public function update_category($category_id, array $attributes);
    public function delete_category($category_id);
    public function search_by_category($query);

}
