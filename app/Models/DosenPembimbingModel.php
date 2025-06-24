<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbingModel extends Model
{
    use HasFactory;

    protected $table = 'm_dosen_pembimbing';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'nip',
        'nama'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function dosenPembimbingPeran()
    {
        return $this->hasOne(DosenPembimbingPeranModel::class, 'nip', 'nip');
    }

    public function bidang_keahlians()
    {
        return $this->belongsToMany(BidangKeahlianModel::class, 't_keahlian_dosen_pembimbing', 'nip', 'bidang_keahlian_id')->withTimestamps();
    }

    public function minats()
    {
        return $this->belongsToMany(MinatModel::class, 't_minat_dosen_pembimbing', 'nip', 'minat_id')->withTimestamps();
    }

    public function kompetensis()
    {
        return $this->belongsToMany(KompetensiModel::class, 't_kompetensi_dosen_pembimbing', 'nip', 'kompetensi_id')->withTimestamps();
    }

    public function keahlian_dosen_pembimbings()
    {
        return $this->hasMany(KeahlianDosenPembimbingModel::class, 'nip', 'nip');
    }

    public function minat_dosen_pembimbings()
    {
        return $this->hasMany(MinatDosenPembimbingModel::class, 'nip', 'nip');
    }

    public function kompetensi_dosen_pembimbings()
    {
        return $this->hasMany(KompetensiDosenPembimbingModel::class, 'nip', 'nip');
    }
}
