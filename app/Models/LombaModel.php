<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LombaModel extends Model
{
    use HasFactory;

    protected $table = 'm_lomba';
    protected $primaryKey = 'lomba_id';

    protected $fillable = [
        'lomba_nama',
        'lomba_kategori',
        'lomba_penyelenggara',
        'lomba_poster_url',
        'lomba_lokasi_preferensi',
        'lomba_tingkat',
        'lomba_persyaratan',
        'lomba_mulai_pendaftaran',
        'lomba_akhir_pendaftaran',
        'lomba_link_registrasi',
        'lomba_mulai_pelaksanaan',
        'lomba_selesai_pelaksanaan',
        'lomba_ukuran_kelompok',
        'periode_id',
        'lomba_status',
        'validated_at',
    ];

    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }

    public function kelompoks()
    {
        return $this->hasMany(KelompokModel::class, 'lomba_id', 'lomba_id');
    }

    public function prestasis()
    {
        return $this->hasManyThrough(PrestasiModel::class, KelompokModel::class, 'lomba_id', 'kelompok_id', 'lomba_id', 'kelompok_id');
    }

    protected $casts = [
        'lomba_mulai_pendaftaran' => 'date',
        'lomba_akhir_pendaftaran' => 'date',
        'lomba_mulai_pelaksanaan' => 'date',
        'lomba_selesai_pelaksanaan' => 'date',
        'validated_at' => 'datetime',
        'lomba_ukuran_kelompok' => 'integer',
    ];

    // Accessor untuk URL poster
    public function getPosterUrlAttribute()
    {
        if ($this->lomba_poster_url) {
            return asset('storage/' . $this->lomba_poster_url);
        }
        return null;
    }

    // Scope untuk status aktif
    public function scopeActive($query)
    {
        return $query->where('lomba_status', 'Akan datang');
    }

    // Scope untuk filter berdasarkan periode
    public function scopeByPeriode($query, $periodeId)
    {
        return $query->where('periode_id', $periodeId);
    }
}
