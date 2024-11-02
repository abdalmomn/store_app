<?php
namespace App\Repositories\wallets;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletRepository implements WalletsRepositoryInterface {
    public function show_my_wallet()
    {
        $wallet = Wallet::query()
            ->where('user_id',Auth::id())
            ->first();
        if ($wallet){
            $message = 'getting wallet successfully';
        }else{
            $message = 'not found';
        }
        return [
            'wallet' => $wallet,
            'message' => $message
        ];
    }
    public function show_user_wallet($user_id)
    {
        if (Auth::user()->hasRole('admin')) {
            $wallet = Wallet::query()
                ->where('id', $user_id)
                ->first();
            if ($wallet) {
                $message = 'getting wallet successfully';
            } else {
                $message = 'not found';
            }
        }else{
            $wallet = null;
            $message = 'you do not have the permissions to access';
        }
        return [
            'wallet' => $wallet,
            'message' => $message
        ];
    }
}
