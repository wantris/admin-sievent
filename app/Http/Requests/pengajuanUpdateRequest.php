<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class pengajuanUpdateRequest extends FormRequest
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
            'event_internal_id' => 'required|integer',
            'validate_pembina' => 'required|integer',
            'validate_wadir3' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'event_internal_id.integer' => 'Pilih Internal',
            'validate_pembina.integer' => 'Pilih status validasi pembina',
            'validate_wadir3.integer' => 'Pilih status validasi wadir 3',
        ];
    }
}
