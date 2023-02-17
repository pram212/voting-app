<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCalonRequest extends FormRequest
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
            'no_urut' =>['required', Rule::unique('calons')->ignore($this->calon)],
            'keterangan' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'no_urut.required' => 'nomor urut wajib diisi!',
            'keterangan.required' => 'keterangan wajib diisi!',
            'no_urut.unique' => 'nomor urut sudah terdaftar'
        ];
    }

}