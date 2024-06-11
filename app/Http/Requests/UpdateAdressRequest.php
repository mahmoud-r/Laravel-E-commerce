<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAdressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'district' => 'nullable|string|max:255',
            'governorate_id' => 'required|exists:governorates,id',
            'nearest_landmark' => 'nullable|string|max:255',
            'phone' => 'required|phone:EG',
            'second_phone' => 'nullable|phone:EG',
            'is_primary' => 'boolean'
        ];
    }
    public function messages(): array
    {
        return [
            'phone.phone' => 'The phone number must be a valid EG phone number.',
            'second_phone.phone' => 'The phone number must be a valid EG phone number.',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
