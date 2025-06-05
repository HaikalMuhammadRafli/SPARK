<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'm_mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'lokasi_preferensi',
        'prodi_id'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudiModel::class, 'program_studi_id', 'program_studi_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }

    public function minats()
    {
        return $this->belongsToMany(MinatModel::class, 't_minat_mahasiswa', 'nim', 'minat_id')->withTimestamps();
    }

    public function bidang_keahlians()
    {
        return $this->belongsToMany(BidangKeahlianModel::class, 't_keahlian_mahasiswa', 'nim', 'bidang_keahlian_id')->withTimestamps();
    }

    public function kompetensis()
    {
        return $this->belongsToMany(KompetensiModel::class, 't_kompetensi_mahasiswa', 'nim', 'kompetensi_id')->withTimestamps();
    }

    public function perans()
    {
        return $this->hasMany(MahasiswaPeranModel::class, 'nim', 'nim');
    }

    public function keahlian_mahasiswas()
    {
        return $this->hasMany(KeahlianMahasiswaModel::class, 'nim', 'nim');
    }

    public function minat_mahasiswas()
    {
        return $this->hasMany(MinatMahasiswaModel::class, 'nim', 'nim');
    }

    public function kompetensi_mahasiswas()
    {
        return $this->hasMany(KompetensiMahasiswaModel::class, 'nim', 'nim');
    }
}
