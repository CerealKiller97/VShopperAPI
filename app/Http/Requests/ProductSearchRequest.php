<?php

namespace App\Http\Requests;

use App\Http\Requests\PagedRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends PagedRequest
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
        return array_merge(parent::rules(), [
            'minPrice'  => 'nullable|numeric',
            'maxPrice'  => 'nullable|numeric',
            'brand'     => 'nullable|numeric',
            'discount'  => 'nullable|numeric'
        ]);
    }
}
