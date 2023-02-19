<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVillageRequest extends FormRequest
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
            'district_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'nama kota wajib diisi', 
            'district_id.required' => 'nama kecamatan wajib diisi', 
        ];
    }
}
