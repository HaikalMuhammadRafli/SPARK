<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiModel extends Model
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
        'kelompok_id',
        'validated_at'
    ];

    public function kelompok()
    {
        return $this->belongsTo(KelompokModel::class, 'kelompok_id', 'kelompok_id');
    }
}
