<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends FormRequest
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
            'perPage'   => 'nullable|numeric',
            'page'      => 'nullable|numeric',
            'name'      => 'nullable|max:255',
            'minPrice'  => 'nullable|numeric',
            'maxPrice'  => 'nullable|numeric',
            'brand'     => 'nullable|numeric',
            'discount'  => 'nullable|numeric'
        ];
    }
}
