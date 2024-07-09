<?php

namespace App\Services;
use App\Http\Requests\StoreAddressRequest;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AddressService
{
    public function validateAndCreateAddress($request)
    {
        $validator = Validator::make($request->all(), (new StoreAddressRequest)->rules(), (new StoreAddressRequest)->messages());


        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return auth()->user()->addresses()->create($request->all());
    }

    public function getAddress($addressId)
    {
        return UserAddress::where('user_id', auth()->id())->where('id', $addressId)->firstOrFail();
    }
}
