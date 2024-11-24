<?php
namespace App\Repositories\coupons;

interface CouponsRepositoryInterface{
    public function show_coupon($coupon_id);

    public function show_all_coupons();

    public function create_coupon($request);

    public function update_coupon($coupon_id,$request);

    public function delete_coupon($coupon_id);
}
