<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProfileAddBidangKeahlianRequest extends FormRequest
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
        return [
            'bidang_keahlian' => ['required', 'array', 'min:1'],
            'bidang_keahlian.*' => ['required', 'integer', Rule::exists('m_bidang_keahlian', 'bidang_keahlian_id')],
        ];
    }

    public function messages(): array
    {
        return [
            'bidang_keahlian.required' => 'Bidang keahlian wajib dipilih.',
            'bidang_keahlian.*.required' => 'Setiap bidang keahlian wajib dipilih.',
            'bidang_keahlian.*.integer' => 'Setiap bidang keahlian harus berupa ID yang valid.',
            'bidang_keahlian.*.exists' => 'Bidang keahlian yang dipilih tidak valid.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validasi gagal.',
            'msgField' => $validator->errors()
        ]));
    }
}
