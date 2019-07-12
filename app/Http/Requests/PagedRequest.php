<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use stdClass;


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
    public function rules(): array
    {
        return [
            'perPage' => 'nullable|numeric',
            'page'    => 'nullable|numeric',
            'name'    => 'nullable|max:255'
        ];
    }

    public function getPaging(): stdClass
    {
        $obj = new stdClass;
        $obj->page = (int) $this->page ?? 1;
        $obj->perPage = (int) $this->perPage ?? 50;
        $obj->name = $this->name ?? null;
        return $obj;
    }
}
