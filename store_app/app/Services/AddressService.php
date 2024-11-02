<?php

namespace App\Services;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressService{
    public function save_address($request)
    {
        $primary = Address::query()->where('user_id' , Auth::id())
            ->where('primary' , '=' , 1)
            ->first();

        $request['user_id'] = Auth::id();
        $address = Address::query()->create($request);
        if (!$primary){
            //if there is no addresses for this user
            $address['primary'] = 1;
            $address->save();
        }else {
            $address['primary'] = 0;
            $address->save();
        }
        return [
            'address' => $address,
            'message' => 'address saved successfully',
        ];
    }

//    public function show_addresses()
//    {
//        $addresses = Address::query()
//            ->where('user_id',Auth::id())
//            ->orderBy('primary' , 'desc')
//            ->get();
//        if ($addresses){
//            $message = 'getting addresses successfully';
//        }else{
//            $addresses = null;
//            $message = 'not found';
//        }
//        return [
//            'addresses' => $addresses,
//            'message' => $message
//        ];
//    }

    public function make_primary($address_id)
    {
        $new_primary = Address::query()
            ->where('user_id' , Auth::id())
            ->where('id' , $address_id)
            ->first();
        if ($new_primary){
            $current_primary = Address::query()
                ->where('user_id' , Auth::id())
                ->where('primary' , '=' , 1)
                ->first();
            if ($current_primary){
                $current_primary->primary = 0;
                $current_primary->save();
            }
            $new_primary->primary = 1;
            $new_primary->save();
            $message = 'primary address switched successfully';
        }else{
            $new_primary = null;
            $message = 'not found';
        }

        return [
            'new_primary' => $new_primary,
            'message' => $message
        ];

    }
    public function edit_address($address_id,$request)
    {
        Address::query()
            ->where('id' , $address_id)
            ->update($request);
        $address = Address::find($address_id);
        return [
            'address' => $address,
            'message' => 'address updated successfully'
        ];
    }
    public function delete_address($address_id)
    {
        Address::query()
            ->where('id' , $address_id)
            ->delete();
        return [
            'address' => '',
            'message' => 'address deleted successfully'
        ];
    }

}
