<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTPSRequest extends FormRequest
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
            'province_id' => ['required'],
            'regency_id' => ['required'],
            'district_id' => ['required'],
            'village_id' => ['required'],
            'nomor' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'province_id.required' => 'provinsi wajib diisi!',
            'regency_id.required' => 'kota wajib diisi!',
            'district_id.required' => 'kecamatan wajib diisi!',
            'village_id.required' => 'desa wajib diisi!',
            'nomor.required' => 'nomor/keterangan wajib diisi!',
        ];
    }
    
}
