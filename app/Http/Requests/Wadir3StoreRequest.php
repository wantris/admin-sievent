<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Wadir3StoreRequest extends FormRequest
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
            'status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'nidn.required' => 'Pilih Dosen!',
            'status.boolean' => 'Pilih status!'
        ];
    }
}
