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

    public function dosen_pembimbing_perans()
    {
        return $this->hasMany(DosenPembimbingPeranModel::class, 'kelompok_id', 'kelompok_id');
    }

    public function mahasiswas()
    {
        return $this->belongsToMany(MahasiswaModel::class, 'm_mahasiswa_peran', 'kelompok_id', 'mahasiswa_id');
    }

    public function dosen_pembimbings()
    {
        return $this->hasMany(DosenPembimbingModel::class, 'kelompok_id', 'kelompok_id');
    }
}
