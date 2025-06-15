<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanAnalisisPrestasiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'prestasi_juara' => 'required|string|max:255',
            'prestasi_surat_tugas_url' => 'required|url',
            'prestasi_poster_url' => 'required|url',
            'prestasi_foto_juara_url' => 'required|url',
            'prestasi_proposal_url' => 'required|url',
            'prestasi_sertifikat_url' => 'required|url',
            'prestasi_status' => 'required|string|max:100',
            'prestasi_catatan' => 'nullable|string',
            'lomba_id' => 'required|integer|exists:lombas,id',
            'nim' => 'required|string|exists:mahasiswas,nim',
        ];
    }
}
