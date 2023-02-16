<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalonPejabatRequest extends FormRequest
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
            'nama' => 'required',
            'jabatan_id' => 'required',
            'no_urut' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'nama wajib diisi',
            'jabatan_id.required' => 'jabatan wajib diisi',
            'no_urut.required' => 'nomor urut wajib diisi',
        ];
    }
    
}
