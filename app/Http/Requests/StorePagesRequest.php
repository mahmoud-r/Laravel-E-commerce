<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class storePagesRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'homeSections' => 'array',
            'homeSections.section1' => 'sometimes|required|array',
            'homeSections.section1.title' => 'sometimes|required|string|max:255',
            'homeSections.section1.description' => 'sometimes|required|string',

            'homeSections.section2' => 'sometimes|required|array',
            'homeSections.section2.title' => 'sometimes|required|string|max:255',

            'homeSections.section3' => 'sometimes|required|array',
            'homeSections.section3.title' => 'sometimes|required|string|max:255',
            'homeSections.section3.subsections' => 'sometimes|required|array',
            'homeSections.section3.subsections.*.title' => 'sometimes|required|string|max:255',
            'homeSections.section3.subsections.*.source_type' => 'sometimes|required|string|in:category,collection,top_rated',
            'homeSections.section3.subsections.*.source_id' => 'sometimes|integer|nullable',

            'homeSections.section4' => 'sometimes|required|array',
            'homeSections.section4.title' => 'sometimes|required|string|max:255',
            'homeSections.section4.subsections' => 'sometimes|required|array',
            'homeSections.section4.subsections.*.source_type' => 'sometimes|sometimes|required|string|in:category,collection,top_rated',
            'homeSections.section4.subsections.*.source_id' => 'sometimes|integer|nullable',

            'homeSections.section5' => 'sometimes|required|array',
            'homeSections.section5.title' => 'sometimes|required|string|max:255',
            'homeSections.section5.subsections' => 'sometimes|required|array',
            'homeSections.section5.subsections.*.title' => 'sometimes|required|string|max:255',
            'homeSections.section5.subsections.*.source_type' => 'sometimes|required|string|in:category,collection,top_rated',
            'homeSections.section5.subsections.*.source_id' => 'sometimes|integer|nullable',


            'homeBanners.banner1.link' => 'sometimes|url',
            'homeBanners.banner1.status' => 'sometimes|in:0,1',
            'homeBanners.banner1.img' => 'sometimes|string',

            'homeBanners.banner2.link' => 'sometimes|url',
            'homeBanners.banner2.status' => 'sometimes|in:0,1',
            'homeBanners.banner2.img' => 'sometimes|string',


            'homeBanners.banner3.link' => 'sometimes|url',
            'homeBanners.banner3.status' => 'sometimes|in:0,1',
            'homeBanners.banner3.img' => 'sometimes|string',


            'contact.title' => 'sometimes|required|string|max:255',
            'contact.slug' => 'sometimes|required|string|max:255|alpha_dash',
            'contact.address' => 'sometimes|string|max:255|nullable',
            'contact.email' => 'sometimes|email|max:255|nullable',
            'contact.phone' => 'sometimes|string|max:20|nullable',
            'contact.form_title' => 'sometimes|string|max:255|nullable',
            'contact.description' => 'sometimes|string|nullable',
            'contact.map_latitude' => 'sometimes|numeric|between:-90,90|nullable',
            'contact.map_longitude' => 'sometimes|numeric|between:-180,180|nullable',
            'contact.zoom' => 'sometimes|integer|between:0,21|nullable',


            'about.title' => 'sometimes|required|string|max:255',
            'about.slug' => 'sometimes|required|string|max:255|alpha_dash',
            'about.section1.title' => 'sometimes|required|string|max:255',
            'about.section1.description' => 'sometimes|string|nullable',
            'about.section2.title' => 'sometimes|required|string|max:255',
            'about.section2.description' => 'sometimes|string|nullable',
            'about.section2.subsections.box1.title' => 'sometimes|required|string|max:255',
            'about.section2.subsections.box1.description' => 'sometimes|string|nullable',
            'about.section2.subsections.box2.title' => 'sometimes|required|string|max:255',
            'about.section2.subsections.box2.description' => 'sometimes|string|nullable',
            'about.section2.subsections.box3.title' => 'sometimes|required|string|max:255',
            'about.section2.subsections.box3.description' => 'sometimes|string|nullable',


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
