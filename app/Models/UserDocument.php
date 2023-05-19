<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'scan_ktp',
        'scan_s1',
        'scan_s2',
        'scan_drg',
        'scan_drgsp',
        'scan_foto',
        'scan_kta',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
