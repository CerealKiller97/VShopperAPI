<?php

namespace App\Http\Requests\Vendors;

use App\Http\Requests\PagedRequest;

class VendorSearchRequest extends PagedRequest
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
        return array_merge(parent::rules(), []);
    }
}
