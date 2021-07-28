<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class pengajuanEksternalUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'event_eksternal_id' => 'required|integer',
            'validate_pembina' => 'required|integer',
            'validate_wadir3' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'event_eksternal_id.integer' => 'Pilih Eksternal',
            'validate_pembina.integer' => 'Pilih status validasi pembina',
            'validate_wadir3.integer' => 'Pilih status validasi wadir 3',
        ];
    }
}
