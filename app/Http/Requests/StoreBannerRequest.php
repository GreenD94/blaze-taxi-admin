<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
            'name' => 'required|string',
            'image' => 'required|mimes:jpeg,jpg,png',
            'user_type' => 'required|string|in:riders,drivers',
            'status' => 'required|string|in:active,inactive',

        ];
    }
}
