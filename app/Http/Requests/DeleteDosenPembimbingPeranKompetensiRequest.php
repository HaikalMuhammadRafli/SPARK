<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteDosenPembimbingPeranKompetensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kompetensi_id' => [
                'required',
                'integer',
                Rule::exists('m_kompetensi', 'kompetensi_id')
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'kompetensi_id.required' => 'Kompetensi ID is required',
            'kompetensi_id.integer' => 'Kompetensi ID must be an integer',
            'kompetensi_id.exists' => 'Selected Kompetensi ID does not exist',
        ];
    }
}
