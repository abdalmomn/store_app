<?php
namespace App\Repositories\wallets;

interface WalletsRepositoryInterface{

    public function show_my_wallet();

    public function show_user_wallet($user_id);
}

