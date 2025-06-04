<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKompetensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kompetensi_nama' => [
                'sometimes',
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->all())) {
                $validator->errors()->add('request', 'At least one field must be provided.');
            }
        });
    }
}
