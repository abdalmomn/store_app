<?php
namespace App\Repositories;

interface ProfileRepositoryInterface {
    public function get_all_profiles();
    public function show_profile($id);
    public function update_profile($id, array $data);
    public function delete_profile($id);
}
