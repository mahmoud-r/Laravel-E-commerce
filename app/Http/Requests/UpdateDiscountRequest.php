<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDiscountRequest extends FormRequest
{
    protected $codeId;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $this->codeId = $this->route('discount');
        return [
            'code' => 'required|string|unique:discount_coupons,code,'.$this->codeId,
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'max_uses' => 'nullable|integer|min:0',
            'max_uses_user' => 'nullable|integer|min:0',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'status' => 'required|integer|in:0,1',
            'starts_at' => 'nullable|date|after_or_equal:today',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
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
