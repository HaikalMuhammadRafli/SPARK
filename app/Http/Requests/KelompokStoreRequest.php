<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class KelompokStoreRequest extends FormRequest
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
            'kelompok_nama' => [
                'required',
                'string',
                'max:255',
            ],
            'lomba_id' => [
                'required',
                'integer',
                Rule::exists('m_lomba', 'lomba_id'),
            ],
            'mahasiswa' => [
                'required',
                'array',
                'min:1',
            ],
            'mahasiswa.*' => [
                'required',
                'string',
                Rule::exists('m_mahasiswa', 'nim'),
                'distinct',
            ],
            'peran_mhs' => [
                'required',
                'array',
                'min:1',
            ],
            'peran_mhs.*' => [
                'required',
                'string',
                'max:100',
                Rule::in(['Ketua', 'Anggota']),
            ],
            'kompetensi_mhs' => [
                'required',
                'array',
                'min:1',
            ],
            'kompetensi_mhs.*' => [
                'required',
                'array',
                'min:1',
            ],
            'kompetensi_mhs.*.*' => [
                'required',
                'integer',
                Rule::exists('m_kompetensi', 'kompetensi_id'),
            ],
            'dosen_pembimbing' => [
                'required',
                'string',
                Rule::exists('m_dosen_pembimbing', 'nip'),
            ],
            'peran_dpm' => [
                'required',
                'string',
                'max:100',
                Rule::in(
                    [
                        'Pembimbing kegiatan mahasiswa',
                        'Pembimbing produk tingkat kota',
                        'Pembimbing produk tingkat provinsi',
                        'Pembimbing produk tingkat nasional',
                        'Pembimbing produk tingkat internasional',
                        'Pembimbing kompetisi tingkat kota',
                        'Pembimbing kompetisi tingkat provinsi',
                        'Pembimbing kompetisi tingkat nasional',
                        'Pembimbing kompetisi tingkat internasional',
                    ]
                ),
            ],
            'kompetensi_dpm' => [
                'required',
                'array',
                'min:1',
            ],
            'kompetensi_dpm.*' => [
                'required',
                'integer',
                Rule::exists('m_kompetensi', 'kompetensi_id'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'kelompok_nama.required' => 'Nama kelompok wajib diisi.',
            'kelompok_nama.string' => 'Nama kelompok harus berupa teks.',
            'kelompok_nama.max' => 'Nama kelompok maksimal 255 karakter.',
            'lomba_id.required' => 'Lomba wajib dipilih.',
            'lomba_id.integer' => 'Lomba yang dipilih tidak valid.',
            'lomba_id.exists' => 'Lomba yang dipilih tidak ditemukan.',
            'mahasiswa.required' => 'Mahasiswa wajib dipilih.',
            'mahasiswa.array' => 'Data mahasiswa tidak valid.',
            'mahasiswa.min' => 'Minimal harus ada satu mahasiswa dalam kelompok.',
            'mahasiswa.*.required' => 'Mahasiswa wajib diisi.',
            'mahasiswa.*.string' => 'NIM mahasiswa harus berupa teks.',
            'mahasiswa.*.exists' => 'Mahasiswa yang dipilih tidak ditemukan.',
            'mahasiswa.*.distinct' => 'Tidak boleh ada mahasiswa yang sama dalam satu kelompok.',
            'peran_mhs.required' => 'Peran mahasiswa wajib diisi.',
            'peran_mhs.array' => 'Data peran mahasiswa tidak valid.',
            'peran_mhs.min' => 'Minimal harus ada satu peran mahasiswa.',
            'peran_mhs.*.required' => 'Peran mahasiswa wajib diisi.',
            'peran_mhs.*.string' => 'Peran mahasiswa harus berupa teks.',
            'peran_mhs.*.max' => 'Peran mahasiswa maksimal 100 karakter.',
            'peran_mhs.*.in' => 'Peran mahasiswa harus Ketua atau Anggota.',
            'kompetensi_mhs.required' => 'Kompetensi mahasiswa wajib diisi.',
            'kompetensi_mhs.array' => 'Data kompetensi mahasiswa tidak valid.',
            'kompetensi_mhs.min' => 'Minimal harus ada satu kompetensi mahasiswa.',
            'kompetensi_mhs.*.required' => 'Kompetensi mahasiswa wajib diisi.',
            'kompetensi_mhs.*.array' => 'Data kompetensi mahasiswa tidak valid.',
            'kompetensi_mhs.*.min' => 'Setiap mahasiswa harus memiliki minimal satu kompetensi.',
            'kompetensi_mhs.*.*.required' => 'Kompetensi mahasiswa wajib diisi.',
            'kompetensi_mhs.*.*.integer' => 'Kompetensi yang dipilih tidak valid.',
            'kompetensi_mhs.*.*.exists' => 'Kompetensi yang dipilih tidak ditemukan.',
            'dosen_pembimbing.required' => 'Dosen pembimbing wajib dipilih.',
            'dosen_pembimbing.string' => 'NIP dosen pembimbing harus berupa teks.',
            'dosen_pembimbing.exists' => 'Dosen pembimbing yang dipilih tidak ditemukan.',
            'peran_dpm.required' => 'Peran dosen pembimbing wajib diisi.',
            'peran_dpm.string' => 'Peran dosen pembimbing harus berupa teks.',
            'peran_dpm.max' => 'Peran dosen pembimbing maksimal 100 karakter.',
            'peran_dpm.in' => 'Peran dosen pembimbing harus Pembimbing Utama atau Pembimbing Pendamping.',
            'kompetensi_dpm.required' => 'Kompetensi dosen pembimbing wajib diisi.',
            'kompetensi_dpm.array' => 'Data kompetensi dosen pembimbing tidak valid.',
            'kompetensi_dpm.min' => 'Dosen pembimbing harus memiliki minimal satu kompetensi.',
            'kompetensi_dpm.*.required' => 'Kompetensi dosen pembimbing wajib diisi.',
            'kompetensi_dpm.*.integer' => 'Kompetensi dosen pembimbing yang dipilih tidak valid.',
            'kompetensi_dpm.*.exists' => 'Kompetensi dosen pembimbing yang dipilih tidak ditemukan.',
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
