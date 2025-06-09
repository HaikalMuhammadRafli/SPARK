<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LombaStoreRequest extends FormRequest
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
            'lomba_nama' => 'required|string|min:3|max:255',
            'lomba_kategori' => 'required|string|max:100',
            'lomba_penyelenggara' => 'required|string|max:255',
            'lomba_tingkat' => 'required|string|in:Lokal,Regional,Nasional,Internasional',
            'lomba_lokasi_preferensi' => 'required|string|max:255',
            'periode_id' => 'required|exists:periode,periode_id',
            'lomba_mulai_pendaftaran' => 'required|date',
            'lomba_akhir_pendaftaran' => 'required|date|after:lomba_mulai_pendaftaran',
            'lomba_status' => 'required|string|in:buka,tutup,selesai',
            'lomba_poster' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB max
            'lomba_deskripsi' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'lomba_nama.required' => 'Nama lomba wajib diisi.',
            'lomba_nama.min' => 'Nama lomba minimal 3 karakter.',
            'lomba_nama.max' => 'Nama lomba maksimal 255 karakter.',
            'lomba_kategori.required' => 'Kategori lomba wajib diisi.',
            'lomba_kategori.max' => 'Kategori lomba maksimal 100 karakter.',
            'lomba_penyelenggara.required' => 'Penyelenggara wajib diisi.',
            'lomba_penyelenggara.max' => 'Penyelenggara maksimal 255 karakter.',
            'lomba_tingkat.required' => 'Tingkat lomba wajib dipilih.',
            'lomba_tingkat.in' => 'Tingkat lomba harus salah satu dari: Lokal, Regional, Nasional, Internasional.',
            'lomba_lokasi_preferensi.required' => 'Lokasi lomba wajib diisi.',
            'lomba_lokasi_preferensi.max' => 'Lokasi lomba maksimal 255 karakter.',
            'periode_id.required' => 'Periode wajib dipilih.',
            'periode_id.exists' => 'Periode yang dipilih tidak valid.',
            'lomba_mulai_pendaftaran.required' => 'Tanggal mulai pendaftaran wajib diisi.',
            'lomba_mulai_pendaftaran.date' => 'Format tanggal mulai pendaftaran tidak valid.',
            'lomba_akhir_pendaftaran.required' => 'Tanggal akhir pendaftaran wajib diisi.',
            'lomba_akhir_pendaftaran.date' => 'Format tanggal akhir pendaftaran tidak valid.',
            'lomba_akhir_pendaftaran.after' => 'Tanggal akhir pendaftaran harus setelah tanggal mulai pendaftaran.',
            'lomba_status.required' => 'Status lomba wajib dipilih.',
            'lomba_status.in' => 'Status lomba harus salah satu dari: buka, tutup, selesai.',
            'lomba_poster.image' => 'File poster harus berupa gambar.',
            'lomba_poster.mimes' => 'Format file poster harus JPG, JPEG, atau PNG.',
            'lomba_poster.max' => 'Ukuran file poster maksimal 2MB.',
            'lomba_deskripsi.max' => 'Deskripsi lomba maksimal 1000 karakter.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'lomba_nama' => 'nama lomba',
            'lomba_kategori' => 'kategori lomba',
            'lomba_penyelenggara' => 'penyelenggara',
            'lomba_tingkat' => 'tingkat lomba',
            'lomba_lokasi_preferensi' => 'lokasi lomba',
            'periode_id' => 'periode',
            'lomba_mulai_pendaftaran' => 'tanggal mulai pendaftaran',
            'lomba_akhir_pendaftaran' => 'tanggal akhir pendaftaran',
            'lomba_status' => 'status lomba',
            'lomba_poster' => 'poster lomba',
            'lomba_deskripsi' => 'deskripsi lomba',
        ];
    }
}