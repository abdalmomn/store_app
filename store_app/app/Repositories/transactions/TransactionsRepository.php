<?php
namespace App\Repositories\transactions;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class TransactionsRepository implements TransactionsRepositoryInterface{


    public function show_all_transactions()
    {
        if (Auth::user()->hasRole('admin')) {
            // Fetch only the necessary columns from transactions, wallets, and users
            $transactions = Transaction::select('id', 'type', 'amount', 'wallet_id', 'order_id', 'created_at', 'updated_at')
                ->with(['wallet:id,user_id', 'wallet.user:id']) // Select only the IDs for wallet and user
                ->get();

            // No need to use map or additional transformations since we load everything in one go
            $transactions = $transactions->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'type' => $transaction->type,
                    'amount' => $transaction->amount,
                    'wallet_id' => $transaction->wallet_id,
                    'order_id' => $transaction->order_id,
                    'user_id' => $transaction->wallet->user->id, // Add the user_id here
                    'created_at' => $transaction->created_at,
                    'updated_at' => $transaction->updated_at,
                ];
            });

            $message = 'Getting all transactions successfully';
        } else {
            $transactions = null;
            $message = 'Unauthenticated';
        }

        return [
            'transactions' => $transactions,
            'message' => $message
        ];
    }



    public function show_user_transactions($user_id)
    {
        if (Auth::user()->hasRole('admin')){
            $wallet = Wallet::query()
                ->where('user_id' , $user_id)
                ->first();
            $transactions = Transaction::query()
                ->where('wallet_id' , $wallet->id)
                ->get();
            if ($transactions) {
                $message = 'getting user transactions successfully';
            }else{
                $transactions = null;
                $message = 'there are no transactions fot this user at the moment';
            }
        }else{
            $transactions = null;
            $message = 'unauthenticated';
        }
        return [
            'transactions' => $transactions,
            'message' => $message,
        ];
    }

    public function show_my_transactions()
    {
        if (Auth::user()){
            $wallet = Wallet::query()
                ->where('user_id' , Auth::id())
                ->first();
            $transactions = Transaction::query()
            ->where('wallet_id' , $wallet->id)
            ->get();
            $message = 'getting all transactions successfully';
        }else{
            $transactions = null;
            $message = 'you can not access';
        }
        return [
            'transactions' => $transactions,
            'message' => $message
        ];
    }
}
