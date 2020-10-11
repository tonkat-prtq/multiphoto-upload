<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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

        if ($this->isMethod('get')) return [];
        return [
            'jan' => 'required',
            'name' => 'required',
            'files.*.photo' => 'image|mimes:jpeg,bmp,png',
        ];
    }
}
