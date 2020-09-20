<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name'       => 'required|string',
            'email'      => 'nullable|regex:/^.+@.+$/i',
            'website'    => 'nullable|url',
            'logo'       => 'nullable|mimes:jpeg,bmp,png|dimensions:min_width=100,min_height=100',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'dimensions' => trans('validation.dimensions') . ' The image needs to be minimum 100x100px'
        ];
    }



}
