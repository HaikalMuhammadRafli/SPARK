<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudiModel extends Model
{
    use HasFactory;
    protected $table = 'm_program_studi';
    protected $primaryKey = 'program_studi_id';

    protected $fillable = [
        'program_studi_nama'
    ];

    public function mahasiswas()
    {
        return $this->hasMany(MahasiswaModel::class, 'program_studi_id', 'program_studi_id');
    }
}
