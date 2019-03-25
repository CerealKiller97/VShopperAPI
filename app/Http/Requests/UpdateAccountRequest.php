<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
            'name'     => 'required|regex:/^[A-Z][a-z]+(\s[A-Z][a-z]+)+$/',
            'address'  => 'required|min:5',
            'image'    => 'nullable|image'
        ];
    }
}
