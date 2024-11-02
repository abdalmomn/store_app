<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coupon\CreateCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Http\Responses\Response;
use App\Repositories\coupons\CouponsRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public $couponRepository;

    public function __construct(CouponsRepositoryInterface $couponsRepository)
    {
        $this->couponRepository = $couponsRepository;
    }

    public function show_coupon($coupon_id)
    {
        $data = [];
        try{
            $data = $this->couponRepository->show_coupon($coupon_id);
            return Response::Success($data['coupon'] , $data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function show_all_coupons()
    {
        $data = [];
        try{
            $data = $this->couponRepository->show_all_coupons();
            return Response::Success($data['coupons'] , $data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function create_coupon(CreateCouponRequest $request)
    {
        $data = [];
        try{
            $data = $this->couponRepository->create_coupon($request->validated());
            return Response::Success($data['coupon'] , $data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function update_coupon($coupon_id,UpdateCouponRequest $request)
    {
        $data = [];
        try{
            $data = $this->couponRepository->update_coupon($coupon_id,$request->validated());
            return Response::Success($data['coupon'] , $data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete_coupon($coupon_id)
    {
        $data = [];
        try{
            $data = $this->couponRepository->delete_coupon($coupon_id);
            return Response::Success($data['coupon'] , $data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
}
