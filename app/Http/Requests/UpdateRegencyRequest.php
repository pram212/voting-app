<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRegencyRequest extends FormRequest
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
            'name' => ['required'],
            'province_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'nama kota wajib diisi', 
            'province_id.required' => 'nama provinsi wajib diisi', 
        ];
    }
}
