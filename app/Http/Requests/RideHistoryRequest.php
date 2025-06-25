<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PaymentType;

class RideHistoryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'from_date' => 'nullable|date|before_or_equal:to_date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'payment_type' => 'nullable|string|in:' . implode(',', array_merge(['all'], PaymentType::values())),
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'from_date.date' => 'La fecha inicial debe ser una fecha válida.',
            'from_date.before_or_equal' => 'La fecha inicial debe ser anterior o igual a la fecha final.',
            'to_date.date' => 'La fecha final debe ser una fecha válida.',
            'to_date.after_or_equal' => 'La fecha final debe ser posterior o igual a la fecha inicial.',
            'payment_type.in' => 'El método de pago seleccionado no es válido.',
            'per_page.integer' => 'El número de registros por página debe ser un número entero.',
            'per_page.min' => 'El número de registros por página debe ser al menos 1.',
            'per_page.max' => 'El número de registros por página no puede exceder 100.',
            'page.integer' => 'El número de página debe ser un número entero.',
            'page.min' => 'El número de página debe ser al menos 1.',
        ];
    }

    /**
     * Get the validated data from the request.
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        // Set default values
        $validated['per_page'] = $validated['per_page'] ?? 10;
        $validated['page'] = $validated['page'] ?? 1;
        $validated['payment_type'] = $validated['payment_type'] ?? 'all';

        return $validated;
    }
}
