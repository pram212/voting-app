<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDistrictRequest extends FormRequest
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
            'regency_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'nama kota wajib diisi', 
            'regency_id.required' => 'nama kota wajib diisi', 
        ];
    }
}
