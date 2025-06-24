<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeahlianDosenPembimbingModel extends Model
{
    use HasFactory;

    protected $table = 't_keahlian_dosen_pembimbing';

    protected $fillable = [
        'nip',
        'bidang_keahlian_id'
    ];

    public function dosenPembimbing()
    {
        return $this->belongsTo(DosenPembimbingModel::class, 'nip', 'nip');
    }

    public function bidang_keahlians()
    {
        return $this->belongsTo(BidangKeahlianModel::class, 'bidang_keahlian_id', 'bidang_keahlian_id');
    }
}
