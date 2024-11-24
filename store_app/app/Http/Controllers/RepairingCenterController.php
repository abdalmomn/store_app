<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepairingCenter\RepairProductRequest;
use App\Http\Requests\RepairingCenter\UpdateRepairProductRequest;
use App\Http\Requests\RepairingCenter\updateRepairProductStatusRequest;
use App\Http\Responses\Response;
use App\Services\RepairingCenterService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepairingCenterController extends Controller
{
    public $repairingCenterService;
    public function __construct(RepairingCenterService $repairingCenterService)
    {
        $this->repairingCenterService = $repairingCenterService;
    }

    public function repair_product(RepairProductRequest $request)
    {
        $data = [];
        try {
            $photos = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $image_path = $photo->store('images/product/trade', 'public');

                    // Get the full URL for the stored image
                    $image_url = Storage::disk('public')->path($image_path);

                    // Push the full image URL into the photos array
                    $photos[] = $image_url;
                }
            }
            $data['photos'] = json_encode($photos); // Store the array of URLs as a JSON string
            $repair_product_data = array_merge($request->validated(), $data);

            $data = $this->repairingCenterService->repair_product($repair_product_data);
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function edit_repair_product(UpdateRepairProductRequest $request , $repair_id)
    {
        $photos = [];
        try {
            if ($request->hasFile('photos')){
                foreach ($request->file('photos') as $photo){
                    $image_path = $photo->store('images/product/trade' , 'public');
                    $image_url = Storage::disk('public')->path($image_path);
                    $photos[] = $image_url;
                }
            }
            $data['photos'] = json_encode($photos);
            $repair_product_data = array_merge($request->validated(),$data);

            $data = $this->repairingCenterService->edit_repair_product($repair_product_data,$repair_id);
            return Response::Success($data['product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function change_repair_order_status(updateRepairProductStatusRequest $request,$repair_id)
    {
        $data = [];
        try {
            $data = $this->repairingCenterService->change_repair_order_status($request,$repair_id);
            return Response::Success($data['repair_product'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function cancel_repair_order($repair_id)
    {
        $data = [];
        try {
            $data = $this->repairingCenterService->cancel_repair_order($repair_id);
            return Response::Success($data['repair_order'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
}
