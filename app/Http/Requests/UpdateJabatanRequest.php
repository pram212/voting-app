<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJabatanRequest extends FormRequest
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
            'nama' =>['required', Rule::unique('jabatans')->ignore($this->jabatan)]
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'nama wajib diisi',
            'nama.unique' => 'nama ini sudah terdaftar',
        ];
    }
}
