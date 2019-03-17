<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PagedRequest extends FormRequest
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
            'perPage' => 'nullable|numeric',
            'page'    => 'nullable|numeric'
        ];
    }

    public function getPaging()
    {
        $obj = new \stdClass;
        $obj->page = $this->page ?? 1;
        $obj->perPage = $this->perPage ?? 3;

        return $obj;
    }

}
