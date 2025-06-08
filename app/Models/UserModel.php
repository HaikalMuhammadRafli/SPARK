<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'foto_profil_url',
        'role',
        'status_akun',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function admin()
    {
        return $this->hasOne(AdminModel::class, 'user_id', 'user_id');
    }

    public function dosenPembimbing()
    {
        return $this->hasOne(DosenPembimbingModel::class, 'user_id', 'user_id');
    }

    public function mahasiswa()
    {
        return $this->hasOne(MahasiswaModel::class, 'user_id', 'user_id');
    }

    public function isRole($role)
    {
        return $this->role === $role;
    }

    public function getCurrentData()
    {
        switch ($this->role) {
            case 'admin':
                return $this->admin;
            case 'dosen_pembimbing':
                return $this->dosenPembimbing;
            case 'mahasiswa':
                return $this->mahasiswa;
            default:
                return null;
        }
    }
}
