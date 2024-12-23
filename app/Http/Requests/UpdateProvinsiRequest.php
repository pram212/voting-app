<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProvinsiRequest extends FormRequest
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
            'name' => ['required', Rule::unique('provinces')->ignore($this->provinsi)]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'nama provinsi wajib diisi', 
            'name.unique' => 'nama provinsi telah terdaftar', 
        ];
    }
}
