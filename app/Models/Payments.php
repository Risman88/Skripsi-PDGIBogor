<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'submission_id',
        'jenis_pembayaran',
        'jangka_iuran',
        'jumlah_pembayaran',
        'status',
        'bank_account_id',
        'bukti_pembayaran',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
