<?php

namespace App\Http\Requests;

use App\Http\Requests\PagedRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorageSearchRequest extends PagedRequest
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
        return array_merge(parent::rules(), [
            'name' => 'nullable|max:255'
        ]);
    }
}
