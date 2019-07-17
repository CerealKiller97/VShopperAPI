<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'amount'      => 'required|numeric',
            'valid_from'  => 'required|date|after_or_equal:today',
            'valid_until' => 'required|date|after:valid_from',
            // 'valid_from'  => 'required|date',
            // 'valid_until' => 'required|date',
            'group_id'    => 'nullable|numeric'
        ];
    }
}
