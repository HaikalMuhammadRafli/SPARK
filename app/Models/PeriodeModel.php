<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    use HasFactory;

    protected $table = 'm_periode';
    protected $primaryKey = 'periode_id';

    protected $fillable = [
        'periode_nama',
        'periode_tahun_awal',
        'periode_tahun_akhir'
    ];

    protected $casts = [
        'periode_tahun_awal' => 'integer',
        'periode_tahun_akhir' => 'integer',
    ];

    /**
     * Relationship with LombaModel
     */
    public function lombas()
    {
        return $this->hasMany(LombaModel::class, 'periode_id', 'periode_id');
    }
}
