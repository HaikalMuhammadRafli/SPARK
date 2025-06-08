<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaPeranModel extends Model
{
    use HasFactory;

    protected $table = 't_mahasiswa_peran';
    protected $primaryKey = 'peran_id';

    protected $fillable = [
        'nim',
        'kelompok_id',
        'peran_nama'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'nim', 'nim');
    }

    public function kelompok()
    {
        return $this->belongsTo(KelompokModel::class, 'kelompok_id', 'kelompok_id');
    }

    public function kompetensis()
    {
        return $this->belongsToMany(KompetensiModel::class, 't_mahasiswa_peran_kompetensi', 'peran_id', 'kompetensi_id');
    }
}
