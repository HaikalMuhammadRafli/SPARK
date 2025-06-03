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

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudiModel::class, 'prodi_id', 'prodi_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }

    public function minats()
    {
        return $this->belongsToMany(MinatMahasiswaModel::class, 't_minat_mahasiswa', 'nim', 'minat_id')->withTimestamps();
    }

    public function bidang_keahlians()
    {
        return $this->belongsToMany(KeahlianMahasiswaModel::class, 't_keahlian_mahasiswa', 'nim', 'bidang_keahlian_id')->withTimestamps();
    }
}
