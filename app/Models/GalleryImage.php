<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;
    protected $fillable = ['image_path', 'is_thumbnail'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
    public function scopeThumbnail($query)
    {
        return $query->where('is_thumbnail', true);
    }
}
