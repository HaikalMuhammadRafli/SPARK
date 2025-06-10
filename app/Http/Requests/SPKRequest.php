<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SPKRequest extends FormRequest
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
            'lokasi_preferensi_spk' => 'required|string|in:Kota,Provinsi,Nasional,Internasional',
            'minat_spk' => 'required|array|min:1',
            'minat_spk.*' => 'required|integer|exists:m_minat,minat_id',
            'bidang_keahlian_spk' => 'required|array|min:1',
            'bidang_keahlian_spk.*' => 'required|integer|exists:m_bidang_keahlian,bidang_keahlian_id',
            'kompetensi_spk' => 'required|array|min:1',
            'kompetensi_spk.*' => 'required|integer|exists:m_kompetensi,kompetensi_id',
            'bobot_lokasi_preferensi_spk' => 'required|integer|min:1|max:6',
            'bobot_minat_spk' => 'required|integer|min:1|max:6',
            'bobot_bidang_keahlian_spk' => 'required|integer|min:1|max:6',
            'bobot_kompetensi_spk' => 'required|integer|min:1|max:6',
            'bobot_jumlah_lomba_spk' => 'required|integer|min:1|max:6',
            'bobot_jumlah_prestasi_spk' => 'required|integer|min:1|max:6',
            'jumlah_rekomendasi' => 'required|integer|min:3|max:100',
            'entropy' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'lokasi_preferensi_spk.required' => 'Preferensi lokasi harus dipilih.',
            'lokasi_preferensi_spk.in' => 'Preferensi lokasi tidak valid.',
            'minat_spk.required' => 'Minimal satu minat harus dipilih.',
            'minat_spk.min' => 'Minimal satu minat harus dipilih.',
            'minat_spk.*.exists' => 'Minat yang dipilih tidak valid.',
            'bidang_keahlian_spk.required' => 'Minimal satu bidang keahlian harus dipilih.',
            'bidang_keahlian_spk.min' => 'Minimal satu bidang keahlian harus dipilih.',
            'bidang_keahlian_spk.*.exists' => 'Bidang keahlian yang dipilih tidak valid.',
            'kompetensi_spk.required' => 'Minimal satu kompetensi harus dipilih.',
            'kompetensi_spk.min' => 'Minimal satu kompetensi harus dipilih.',
            'kompetensi_spk.*.exists' => 'Kompetensi yang dipilih tidak valid.',
            'bobot_lokasi_preferensi_spk.required' => 'Bobot preferensi lokasi harus diisi.',
            'bobot_lokasi_preferensi_spk.min' => 'Bobot preferensi lokasi minimal 1.',
            'bobot_lokasi_preferensi_spk.max' => 'Bobot preferensi lokasi maksimal 6.',
            'bobot_minat_spk.required' => 'Bobot minat harus diisi.',
            'bobot_minat_spk.min' => 'Bobot minat minimal 1.',
            'bobot_minat_spk.max' => 'Bobot minat maksimal 6.',
            'bobot_bidang_keahlian_spk.required' => 'Bobot bidang keahlian harus diisi.',
            'bobot_bidang_keahlian_spk.min' => 'Bobot bidang keahlian minimal 1.',
            'bobot_bidang_keahlian_spk.max' => 'Bobot bidang keahlian maksimal 6.',
            'bobot_kompetensi_spk.required' => 'Bobot kompetensi harus diisi.',
            'bobot_kompetensi_spk.min' => 'Bobot kompetensi minimal 1.',
            'bobot_kompetensi_spk.max' => 'Bobot kompetensi maksimal 6.',
            'bobot_jumlah_lomba_spk.required' => 'Bobot jumlah lomba harus diisi.',
            'bobot_jumlah_lomba_spk.min' => 'Bobot jumlah lomba minimal 1.',
            'bobot_jumlah_lomba_spk.max' => 'Bobot jumlah lomba maksimal 6.',
            'bobot_jumlah_prestasi_spk.required' => 'Bobot jumlah prestasi harus diisi.',
            'bobot_jumlah_prestasi_spk.min' => 'Bobot jumlah prestasi minimal 1.',
            'bobot_jumlah_prestasi_spk.max' => 'Bobot jumlah prestasi maksimal 6.',
            'jumlah_rekomendasi.required' => 'Jumlah rekomendasi harus dipilih.',
            'jumlah_rekomendasi.min' => 'Jumlah rekomendasi minimal 3.',
            'jumlah_rekomendasi.max' => 'Jumlah rekomendasi maksimal 10.',
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
