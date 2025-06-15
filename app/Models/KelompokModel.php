<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokModel extends Model
{
    use HasFactory;

    protected $table = 'm_kelompok';
    protected $primaryKey = 'kelompok_id';

    protected $fillable = [
        'kelompok_nama',
        'lomba_id'
    ];

    public function lomba()
    {
        return $this->belongsTo(LombaModel::class, 'lomba_id', 'lomba_id');
    }

    public function prestasis()
    {
        return $this->hasMany(PrestasiModel::class, 'kelompok_id', 'kelompok_id');
    }

    public function mahasiswa_perans()
    {
        return $this->hasMany(MahasiswaPeranModel::class, 'kelompok_id', 'kelompok_id');
    }

    public function dosen_pembimbing_peran()
    {
        return $this->hasOne(DosenPembimbingPeranModel::class, 'kelompok_id', 'kelompok_id');
    }

    // For easier access in forms
    public function mahasiswas()
    {
        return $this->belongsToMany(MahasiswaModel::class, 't_mahasiswa_peran', 'kelompok_id', 'nim')
            ->withPivot(['peran_id', 'peran_nama']);
    }

    public function dosen_pembimbings()
    {
        return $this->belongsToMany(DosenPembimbingModel::class, 't_dosen_pembimbing_peran', 'kelompok_id', 'nip')
            ->withPivot(['peran_id', 'peran_nama']);
    }
     public function mahasiswaPeran()
    {
        return $this->hasMany(MahasiswaPeranModel::class, 'kelompok_id', 'kelompok_id');
    }
}
