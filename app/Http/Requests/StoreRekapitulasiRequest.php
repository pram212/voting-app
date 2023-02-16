<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRekapitulasiRequest extends FormRequest
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
            'calon_pejabat_id' => ['required'],
            // 'jabatan_id' => ['required'],
            'province_id' => ['required'],
            'regency_id' => ['required'],
            'district_id' => ['required'],
            'village_id' => ['required'],
            'jumlah_suara' => ['required'],
            'rt' => ['required'],
            'rw' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'calon_pejabat_id.required' => 'calon pejabat wajib diisi!',
            // 'jabatan_id.required' => 'calon pejabat wajib diisi!',
            'province_id.required' => 'provinsi wajib diisi!',
            'regency_id.required' => 'kota wajib diisi!',
            'district_id.required' => 'kecamatan wajib diisi!',
            'village_id.required' => 'desa wajib diisi!',
            'rt.required' => 'RT wajib diisi!',
            'rw.required' => 'RW wajib diisi!',
            'jumlah_suara.required' => 'jumlah suara wajib diisi!',
        ];
    }
}