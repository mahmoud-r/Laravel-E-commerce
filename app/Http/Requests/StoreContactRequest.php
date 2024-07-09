<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreContactRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255|min:3',
            'phone' => 'nullable|string|max:255|min:11',
            'message' => 'required|string|min:10',
            'g-recaptcha-response' => 'required|recaptchav3:recaptcha,0.3'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'We need to know your name!',
            'email.required' => "Don't forget your email address!",
            'email.email' => 'Please provide a valid email address.',
            'message.required' => 'A message is required to submit the form.',
            'g-recaptcha-response.recaptchav3' => 'You are most likely a bot'
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
