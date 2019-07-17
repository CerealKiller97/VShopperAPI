<?php

declare(strict_types=1);

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
            'perPage' => 'nullable|numeric',
            'page'    => 'nullable|numeric',
            'name'    => 'nullable|max:255'
        ];
    }

    /**
     * @return stdClass
     */
    public function getPaging(): stdClass
    {
        $obj = new stdClass;

        $obj->page =  intval($this->page ?? 1);
        $obj->perPage = intval($this->perPage ?? 50);
        $obj->name = $this->name ?? null;

        return $obj;
    }
}
