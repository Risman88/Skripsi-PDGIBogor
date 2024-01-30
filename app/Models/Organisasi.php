<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    protected $table = 'organisasi';

    protected $fillable = ['photo_url', 'nama', 'jabatan', 'posisi']; // Kolom yang dapat diisi

    public function getNextPosition()
    {
        // Mendapatkan posisi tertinggi dari data yang ada
        $highestPosition = $this->max('posisi');

        // Jika tidak ada data, atur posisi awal menjadi 1
        if (!$highestPosition) {
            return 1;
        }

        // Tambahkan 1 ke posisi tertinggi
        return $highestPosition + 1;
    }

    public static function reorderPositions()
    {
        $organisasi = Organisasi::orderBy('posisi')->get();
        $position = 1;

        foreach ($organisasi as $item) {
            $item->posisi = $position;
            $item->save();
            $position++;
        }
    }
}
