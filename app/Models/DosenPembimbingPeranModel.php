<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbingPeranModel extends Model
{
    use HasFactory;
    protected $table = 't_dosen_pembimbing_peran';
    protected $primaryKey = 'peran_id';

    protected $fillable = [
        'peran_id',
        'nip',
        'kelompok_id',
        'nama_peran'
    ];

    public function dosen_pembimbing()
    {
        return $this->belongsTo(DosenPembimbingModel::class, 'nip', 'nip');
    }

    public function kelompok()
    {
        return $this->belongsTo(KelompokModel::class, 'kelompok_id', 'kelompok_id');
    }
}
