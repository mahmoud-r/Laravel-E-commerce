<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    protected $productId;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $this->productId = $this->route('product');

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$this->product,
            'description' => 'required',
            'price' => 'required|numeric|min:0.01|max:1000000',
            'compare_price' => 'nullable|numeric|min:0.01|max:1000000',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'sku' => 'required|min:5|max:20|unique:products,sku,'.$this->product,
            'qty' => 'required|integer|min:0',

            'flash_sale_qty' => 'nullable|integer|min:0',
            'flash_sale_qty_solid' => 'nullable|integer|min:0',
            'flash_sale_expiry_date' => 'nullable|date',
            'flash_sale_price' => 'nullable|numeric|min:0.01|max:1000000',

            'max_order' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'status' => 'required|boolean|in:0,1',
            'attributes' => 'array',
            'attributes.*.id' => 'exists:attributes,id',
            'attributes.*.value_id' => 'exists:attribute_values,id',
            'seo_index' => 'in:index,noindex',
        ];

        return $rules;
    }


    public function messages(): array
    {
        return [
            'category_id.required' => 'The category is required.',
            'sub_category_id.required' => 'The sub category is required.',
            'brand_id.required' => 'The brand is required.',
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

