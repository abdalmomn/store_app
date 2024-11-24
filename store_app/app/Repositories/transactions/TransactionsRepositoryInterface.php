<?php
namespace App\Repositories\transactions;

interface TransactionsRepositoryInterface{
    public function show_all_transactions();

    public function show_user_transactions($user_id);

    public function show_my_transactions();

}
