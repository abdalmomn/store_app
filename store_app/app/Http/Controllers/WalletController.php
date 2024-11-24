<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Repositories\wallets\WalletsRepositoryInterface;
use Exception;

class WalletController extends Controller
{
    public $walletsRepository;

    public function __construct(WalletsRepositoryInterface $walletsRepository)
    {
        $this->walletsRepository = $walletsRepository;
    }

    public function show_my_wallet()
    {
        $data = [];
        try{
            $data = $this->walletsRepository->show_my_wallet();
            return Response::Success($data['wallet'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }
    public function show_user_wallet($user_id)
    {
        $data = [];
        try{
            $data = $this->walletsRepository->show_user_wallet($user_id);
            return Response::Success($data['wallet'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }
}
