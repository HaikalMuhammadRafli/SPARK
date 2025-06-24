<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeahlianMahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 't_keahlian_mahasiswa';

    protected $fillable = [
        'nim',
        'bidang_keahlian_id'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'nim', 'nim');
    }
}
