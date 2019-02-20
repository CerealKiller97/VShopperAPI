<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'name'     => 'required',
            'email'    => 'required|email|unique:accounts',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
            'address'  => 'required|min:5'
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password must contain 1 uppercase, 1 lowercase 1 number and must be at least 8 characters long'
        ];
    }
}
