<?php

namespace App\Services;

use App\Models\RepairingCenter;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class RepairingCenterService{

    public function repair_product($request)
    {
        $status = Status::query()
            ->where('status' , '=', 'pending')
            ->first();

        // Generate the trading order reference
        $latestId = RepairingCenter::max('id') ?? 0; // Get the latest ID or 0 if no records exist
        $orderReference = 'REPAIR-' . now()->format('Ymd') . '-' . str_pad($latestId + 1, 6, '0', STR_PAD_LEFT);

        $request['repairing_order_reference'] = $orderReference;
        $request['status_id'] = $status->id;
        $request['user_id'] = Auth::id();
        $product = RepairingCenter::query()->create($request);
        $message = 'your order has been sent successfully, please wait for respond';
        return [
            'product' => $product,
            'message' => $message
        ];
    }

    public function edit_repair_product($request,$repair_id)
    {
        $product = RepairingCenter::query()
            ->where('user_id' , Auth::id())
            ->where('id' , $repair_id)
            ->first();
        if ($product){
            $status = Status::query()
                ->where('id' , $product->status_id)
                ->first();
            if ($status->status = 'pending') {
                $product->update($request);
                $product = RepairingCenter::query()->find($repair_id);
                $message = 'your order has been updated successfully';
            }else{
                $product = null;
                $message  = 'you can not update the order in this status';
            }
        }else{
            $product = null;
            $message = 'the repair order not found';
        }
        return [
            'product' => $product,
            'message' => $message
        ];
    }

    public function change_repair_order_status($request,$repair_id)
    {
        if (Auth::user()->hasRole('admin')){
            $repair_order = RepairingCenter::query()
                ->where('id' , $repair_id)
                ->first();
            $status = Status::query()
                ->where('status' , $request['status'])
                ->first();
            $cancel_status = $status->where('status' , '=' , 'canceled')->first();
            if ($repair_order->status_id != $cancel_status->id) {
                if ($repair_order) {
                    $repair_order->update([
                        'status_id' => $status->id
                    ]);
                    //send notification to user that status has been changed

                    $message = 'status has been updated successfully';
                } else {
                    $repair_order = null;
                    $message = 'the order is not found';
                }
            }else{
                $repair_order = null;
                $message = 'the order is already canceled';
            }
        }else{
            $repair_order = null;
            $message = 'unauthenticated';
        }
        return [
            'repair_product' => $repair_order,
            'message' => $message
        ];
    }

    public function cancel_repair_order($repair_id)
    {
        $repair_order = RepairingCenter::query()->find($repair_id);
        $status = Status::all();
        $pending_status = $status->where('status' , '=', 'pending')->first();
        if ($repair_order->status_id == $pending_status->id){
            $cancel_status = $status->where('status' , '=' , 'canceled')->first();
            $repair_order->status_id = $cancel_status->id;
            $repair_order->save();
            $message = 'order canceled successfully';
        }else{
            $repair_order = null;
            $message = 'you can not cancel the order in this status';
        }
        return [
            'repair_order' => $repair_order,
            'message' => $message
        ];
    }
}
