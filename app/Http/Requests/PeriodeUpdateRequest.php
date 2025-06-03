<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PeriodeUpdateRequest extends FormRequest
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
            'periode_nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_periode', 'periode_nama')
                    ->ignore($this->route('periode'), 'periode_id')
            ],
            'periode_tahun_awal' => [
                'required',
                'integer',
                'min:2000',
                'max:9999',
            ],
            'periode_tahun_akhir' => [
                'required',
                'integer',
                'min:2000',
                'max:9999',
                'gte:periode_tahun_awal',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'periode_nama.required' => 'Nama periode wajib diisi.',
            'periode_nama.unique' => 'Nama periode sudah digunakan.',
            'periode_tahun_awal.required' => 'Tahun awal wajib diisi.',
            'periode_tahun_awal.integer' => 'Tahun awal harus berupa angka.',
            'periode_tahun_awal.min' => 'Tahun awal minimal 2000.',
            'periode_tahun_awal.max' => 'Tahun awal maksimal 9999.',
            'periode_tahun_akhir.required' => 'Tahun akhir wajib diisi.',
            'periode_tahun_akhir.integer' => 'Tahun akhir harus berupa angka.',
            'periode_tahun_akhir.min' => 'Tahun akhir minimal 2000.',
            'periode_tahun_akhir.max' => 'Tahun akhir maksimal 9999.',
            'periode_tahun_akhir.gte' => 'Tahun akhir tidak boleh kurang dari tahun awal.',
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