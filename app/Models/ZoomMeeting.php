<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function untuk()
    {
    return $this->belongsTo(User::class, 'untuk_id');
    }

    public function oleh()
    {
    return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
