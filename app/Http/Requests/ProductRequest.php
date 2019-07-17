<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'unit_id'         => 'required|numeric',
            'brand_id'        => 'required|numeric',
            'vendor_id'       => 'required|numeric',
            'product_type_id' => 'required|numeric',
            'name'            => 'required|max:255',
            'description'     => 'required|max:255',
            'categories'      => 'required|array'
        ];
    }

    public function messages(): array
    {
        return [
            'unit_id.required'         => 'Unit is required',
            'brand_id.required'        => 'Brand is required',
            'vendor_id.required'       => 'Vendor is required',
            'product_type_id.required' => 'Product type is required',
        ];
    }
}
