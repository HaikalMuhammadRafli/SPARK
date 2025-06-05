<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nim' => [
                'required',
                'string',
                'max:20',
                Rule::unique('m_mahasiswa', 'nim')
            ],
            'nama' => [
                'required',
                'string',
                'max:255'
            ],
            'lokasi_preferensi' => [
                'required',
                'string',
                'max:255'
            ],
            'prodi_id' => [
                'required',
                'integer',
                'exists:m_program_studi,prodi_id'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nim.required' => 'NIM is required',
            'nim.unique' => 'NIM already exists',
            'nim.max' => 'NIM cannot exceed 20 characters',

            'nama.required' => 'Nama is required',
            'nama.max' => 'Nama cannot exceed 255 characters',

            'lokasi_preferensi.required' => 'Lokasi preferensi is required',
            'lokasi_preferensi.max' => 'Lokasi preferensi cannot exceed 255 characters',

            'prodi_id.required' => 'Program studi is required',
            'prodi_id.exists' => 'Selected program studi does not exist'
        ];
    }
}
