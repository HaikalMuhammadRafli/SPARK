<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LombaModel extends Model
{
    use HasFactory;

    protected $table = 'm_lomba';
    protected $primaryKey = 'lomba_id';

    protected $fillable = [
        'lomba_nama',
        'lomba_kategori',
        'lomba_penyelenggara',
        'lomba_lokasi',
        'lomba_tingkat',
        'lomba_persyaratan',
        'lomba_mulai_pendaftaran',
        'lomba_akhir_pendaftaran',
        'lomba_link_registrasi',
        'lomba_mulai_pelaksanaan',
        'lomba_selesai_pelaksanaan',
        'periode_id',
        'lomba_bidang_keahlian'
    ];

    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }
}
