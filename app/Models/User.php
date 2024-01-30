<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'iuran_at', // Pastikan kolom ini ada di sini
        'iuran_until', // Pastikan kolom ini ada di sini
        'handphone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'iuran_at' => 'datetime', // Pastikan kolom ini ada di sini
        'iuran_until' => 'datetime',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function userDocument()
    {
        return $this->hasOne(UserDocument::class);
    }

    public function payments()
    {
        return $this->hasMany(Payments::class);
    }
}
