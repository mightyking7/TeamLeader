<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeam extends FormRequest
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
            'name'=> 'required|unique:teams|max:65',
            'description'=> 'required|max:255',
            'file' => 'nullable|image|mimes:bmp,gif,jpeg,jpg,jif,jfif,png,svg,tiff,tif|max:10000',
            'recruiting'=> 'required|boolean'
        ];
    }
}
