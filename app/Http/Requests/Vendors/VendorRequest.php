<?php

namespace App\Http\Requests\Vendors;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'name'       => 'required|min:3|max:255',
            'address'    => 'required|alpha_num|max:255',
            'pib'        => 'required|numeric|digits:9',
            'phone'      => 'required|numeric',
            'email'      => 'required|email',
        ];
    }
}
