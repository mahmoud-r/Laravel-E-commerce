<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class storeSetingsRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'store_name'=>'string|max:255',
            'store_phone'=>'phone:EG',
            'store_email'=>'email|max:255',
            'store_address'=>'string|max:255',
            'store_description'=>'string|max:255',
            'email_from_name' => 'string|max:255',
            'email_from_address' => 'email|max:255',
            'email_user_register'=>'boolean',
            'email_user_register_admin'=>'boolean',
            'email_user_new_order'=>'boolean',
            'email_user_new_order_admin'=>'boolean',
            'email_user_confirm_order'=>'boolean',
            'email_user_confirm_payment'=>'boolean',
            'email_user_review_when_order_completed'=>'boolean',
            'email_user_confirm_review'=>'boolean',
            'email_user_new_review_admin'=>'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'store_phone.phone' => 'The phone number must be a valid EG phone number.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422));
    }
}
