<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembinaStoreRequest extends FormRequest
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
            'nidn' => 'required',
            'ormawa' => 'required|integer',
            'status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'nidn.required' => 'Pilih Dosen',
            'ormawa.integer' => 'Pilih Ormawa',
            'status.boolean' => 'Pilih status'
        ];
    }
}
