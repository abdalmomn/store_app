<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\CreateAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Responses\Response;
use App\Services\AddressService;
use Exception;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }
    public function save_address(CreateAddressRequest $request)
    {
        $data = [];
        try{
            $data = $this->addressService->save_address($request->validated());
            return Response::Success($data['address'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function make_primary($address_id)
    {
        $data = [];
        try{
            $data = $this->addressService->make_primary($address_id);
            return Response::Success($data['new_primary'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function show_addresses()
    {
        $data = [];
        try{
            $data = $this->addressService->show_addresses();
            return Response::Success($data['addresses'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function edit_address($address_id,UpdateAddressRequest $request)
    {
        $data = [];
        try{
            $data = $this->addressService->edit_address($address_id,$request->validated());
            return Response::Success($data['address'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete_address($address_id)
    {
        $data = [];
        try{
            $data = $this->addressService->delete_address($address_id);
            return Response::Success($data['address'] , $data['message']);
        }catch(Exception $e){
            $message  = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
}
