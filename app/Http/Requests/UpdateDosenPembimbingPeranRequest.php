<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDosenPembimbingPeranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nip' => [
                'sometimes',
                'nullable',
                'string',
                'exists:m_admin,nip'
            ],
            'kelompok_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('m_kelompok', 'kelompok_id')
            ],
            'peran_nama' => [
                'sometimes',
                'required',
                'string'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nip.exists' => 'NIP must exist in the dosen pembimbing list',

            'kelompok_id.required' => 'Kelompok ID is required',
            'kelompok_id.integer' => 'Kelompok ID must be an integer',
            'kelompok_id.exists' => 'Kelompok ID must exist',

            'peran_nama.required' => 'Peran Nama is required'
        ];
    }
}
