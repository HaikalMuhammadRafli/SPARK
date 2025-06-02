<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class MinatStoreRequest extends FormRequest
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
            'minat_nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_minat', 'minat_nama'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'minat_nama.required' => 'Nama minat wajib diisi.',
            'minat_nama.unique' => 'Nama minat sudah digunakan.',
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