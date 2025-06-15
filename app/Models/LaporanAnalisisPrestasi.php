<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAnalisisPrestasi extends Model
{
    use HasFactory;

    protected $table = 't_prestasi';
    protected $primaryKey = 'prestasi_id';

    protected $fillable = [
        'prestasi_id',
        'prestasi_juara',
        'prestasi_surat_tugas_url',
        'prestasi_poster_url',
        'prestasi_foto_juara_url',
        'prestasi_proposal_url',
        'prestasi_sertifikat_url',
        'prestasi_status',
        'prestasi_catatan',
        'lomba_id',
        'validated_at',
        'nim'
    ];

    protected $casts = [
        'validated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'nim', 'nim');
    }
    public function kelompok()
    {
        return $this->belongsTo(KelompokModel::class, 'kelompok_id', 'kelompok_id');
    }

    public function lomba()
    {
        return $this->belongsTo(LombaModel::class, 'lomba_id', 'lomba_id');
    }

    public function kompetensi()
    {
        return $this->hasMany(KompetensiMahasiswaModel::class, 'nim', 'nim');
    }
}
