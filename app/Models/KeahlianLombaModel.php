<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeahlianLombaModel extends Model
{
    use HasFactory;

    protected $table = 't_keahlian_lomba';
    protected $primaryKey = 'lomba_id';

    protected $fillable = [
        'lomba_id',
        'bidang_keahlian_id'
    ];

    public function lomba()
    {
        return $this->belongsTo(LombaModel::class, 'lomba_id', 'lomba_id');
    }
}
