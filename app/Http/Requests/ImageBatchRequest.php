<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageBatchRequest extends FormRequest
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
            'images' => 'array|required'
        ];
    }

    public function messages()
    {
        return [
            'images.exists' => 'Images do not exist in DB'
        ];
    }
}
