<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'nama_rekening',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
