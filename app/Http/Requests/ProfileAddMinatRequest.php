<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProfileAddMinatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'minat' => ['required', 'array', 'min:1'],
            'minat.*' => ['required', 'integer', Rule::exists('m_minat', 'minat_id')],
        ];
    }

    public function messages(): array
    {
        return [
            'minat.required' => 'Minat wajib dipilih.',
            'minat.*.required' => 'Setiap minat wajib dipilih.',
            'minat.*.integer' => 'Setiap minat harus berupa ID yang valid.',
            'minat.*.exists' => 'Minat yang dipilih tidak valid.',
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
