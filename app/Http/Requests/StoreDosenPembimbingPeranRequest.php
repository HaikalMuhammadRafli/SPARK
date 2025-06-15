<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDosenPembimbingPeranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kelompok_id' => [
                'required',
                'integer',
                Rule::exists('m_kelompok', 'kelompok_id')
            ],
            'peran_nama' => [
                'required',
                'string'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required' => 'NIP is required',
            'nip.max' => 'NIP cannot exceed 20 characters',
            'nip.exists' => 'NIP must exist in the dosen pembimbing list',

            'kelompok_id.required' => 'Kelompok ID is required',
            'kelompok_id.integer' => 'Kelompok ID must be an integer',
            'kelompok_id.exists' => 'Kelompok ID must exist',

            'peran_nama.required' => 'Peran Nama is required'
        ];
    }
}
