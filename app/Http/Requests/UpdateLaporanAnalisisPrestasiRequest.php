<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLaporanAnalisisPrestasiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'prestasi_juara' => 'required|string|max:255',
            'prestasi_surat_tugas_url' => 'nullable|url',
            'prestasi_poster_url' => 'nullable|url',
            'prestasi_foto_juara_url' => 'nullable|url',
            'prestasi_proposal_url' => 'nullable|url',
            'prestasi_sertifikat_url' => 'nullable|url',
            'prestasi_status' => 'nullable|string|max:100',
            'prestasi_catatan' => 'nullable|string',
            'lomba_id' => 'nullable|integer|exists:lombas,id',
            'nim' => 'nullable|string|exists:mahasiswas,nim',
        ];
    }
}
