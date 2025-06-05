<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateMahasiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $nim = $this->route('mahasiswa') ?? $this->route('nim');

        return [
            'nim' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('m_mahasiswa', 'nim')->ignore($this->nim, 'nim')
            ],
            'nama' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
            'lokasi_preferensi' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
            'user_id' => [
                'sometimes',
                'nullable',
                'integer',
                'exists:m_user,user_id'
            ],
            'prodi_id' => [
                'sometimes',
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
            'user_id.exists' => 'Selected user does not exist',
            'prodi_id.required' => 'Program studi is required',
            'prodi_id.exists' => 'Selected program studi does not exist'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->all())) {
                $validator->errors()->add('request', 'At least one field must be provided.');
            }
        });
    }
}
