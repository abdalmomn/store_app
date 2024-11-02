<?php
namespace App\Repositories\coupons;

use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

class CouponsRepository implements CouponsRepositoryInterface{
    public function show_coupon($coupon_id){
        if (Auth::user()->hasRole('admin')){
         $coupon = Coupon::query()
            ->where('id' , $coupon_id)
             ->first();
            if ($coupon){
             $message = 'getting coupon successfully';
            }else{
                $message = 'not found';
            }
        }else{
            $coupon = null;
            $message = 'you do not have access';
        }
        return [
            'coupon' => $coupon,
            'message' => $message
        ];
    }

    public function show_all_coupons(){
        if (Auth::user()->hasRole('admin')){
        $coupons = Coupon::query()->paginate(10);
            if (!$coupons->isEmpty()){
                $message = 'getting all coupons successfully';
            }else{
                $message = 'there are no coupons at this moment';
            }
        }else{
            $coupons = null;
            $message = 'you do not have access';
        }
        return [
            'coupons' => $coupons,
            'message' => $message
        ];
    }

    public function create_coupon($request){
        if (Auth::user()->hasRole('admin')){
            $request['code'] = 'C-'.strtoupper(Str::random(8));
            $coupon = Coupon::query()->create($request);
            $message = 'coupon created successfully';
        }else{
            $coupon = null;
            $message = 'you do not have access';
        }
        return [
            'coupon' => $coupon,
            'message' => $message
        ];
    }

    //we can add a static date for expires codes, one month as example.
    //also we can make all attributes static.
    public function update_coupon($coupon_id,$request){
        if (Auth::user()->hasRole('admin')){
            $coupon = Coupon::query()->find($coupon_id);
            if ($coupon) {
                $coupon = Coupon::query()
                    ->where('id', $coupon_id)
                    ->update($request);
                $coupon = Coupon::query()->find($coupon_id);
                $message = 'coupon updated successfully';
            }else{
                $message = 'not found';
            }
        }else{
            $coupon = null;
            $message = 'you do not have access';
        }
        return [
            'coupon' => $coupon,
            'message' => $message
        ];
    }

    public function delete_coupon($coupon_id){
        if (Auth::user()->hasRole('admin')){
            $coupon = Coupon::query()->find($coupon_id);
            if ($coupon){
                $coupon->delete();
                $message = 'coupon deleted successfully';
            }else{
                $message = 'not found';
            }
        }else{
            $coupon = null;
            $message = 'you do not have access';
        }
        return [
            'coupon' => $coupon,
            'message' => $message
        ];
    }
}
