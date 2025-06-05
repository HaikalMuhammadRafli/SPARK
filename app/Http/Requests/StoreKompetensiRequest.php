<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKompetensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kompetensi_nama' => [
                'required',
                'string',
                'max:255'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'kompetensi_nama.required' => 'Nama kompetensi is required',
            'kompetensi_nama.max' => 'Nama kompetensi cannot exceed 255 characters',
        ];
    }
}
