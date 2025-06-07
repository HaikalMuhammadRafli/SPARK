<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeahlianDosenPembimbingModel extends Model
{
    use HasFactory;

    protected $table = 't_keahlian_dosen_pembimbing';
    protected $primaryKey = 'nip';

    protected $fillable = [
        'nip',
        'bidang_keahlian_id'
    ];

    public function dosenPembimbing()
    {
        return $this->belongsTo(MahasiswaModel::class, 'nip', 'nip');
    }
}
