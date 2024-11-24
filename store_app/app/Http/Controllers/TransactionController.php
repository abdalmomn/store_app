<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Repositories\transactions\TransactionsRepositoryInterface;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public $transactionRepository;

    public function __construct(TransactionsRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }


    public function show_all_transactions()
    {
        $data = [];
        try{
            $data = $this->transactionRepository->show_all_transactions();
            return Response::Success($data['transactions'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }
    public function show_user_transactions($user_id)
    {
        $data = [];
        try{
            $data = $this->transactionRepository->show_user_transactions($user_id);
            return Response::Success($data['transactions'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }public function show_my_transactions()
    {
        $data = [];
        try{
            $data = $this->transactionRepository->show_my_transactions();
            return Response::Success($data['transactions'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }

}
