<?php
namespace App\Repositories;

use App\Models\User;

interface ProfileRepositoryInterface {
    public function show_all_profiles();
    public function show_profile($id);
    public function update_profile($id, $request);
    public function update_password($user, $newPassword);
    public function delete_profile($id);
}
