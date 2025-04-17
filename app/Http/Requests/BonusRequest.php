<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BonusRequest extends FormRequest
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
        $method = strtolower($this->method());

        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'name' => 'required|min:3',
                    'amount' => 'required|numeric',
                    'rides_qty' => 'required|numeric',
                    'start_date_type' => 'required',
                    'starts_at' => 'nullable|date',
                    'end_date_type' => 'required',
                    'ends_at' => 'nullable|date',
                    'days_to_expiration' => 'nullable|numeric',
                    'status' => 'required',
                ];
                break;
            case 'patch':
                $rules = [
                    'name' => 'required|min:3',
                    'amount' => 'required|numeric',
                    'rides_qty' => 'required|numeric',
                    'start_date_type' => 'required',
                    'starts_at' => 'nullable|date',
                    'end_date_type' => 'required',
                    'ends_at' => 'nullable|date',
                    'days_to_expiration' => 'nullable|numeric',
                    'status' => 'required',
                ];
                break;
        }

        return $rules;
    }
}
