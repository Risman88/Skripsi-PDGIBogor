<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'submission_type_id',
        'status',
        'surat_keluar',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function payment()
    {
        return $this->hasOne(Payments::class);
    }

    public function submissionType()
    {
        return $this->belongsTo(SubmissionType::class);
    }

    public function submission_anggota()
    {
        return $this->hasOne(SubmissionAnggota::class);
    }

    public function submission_izin_praktik()
    {
        return $this->hasOne(SubmissionIzinPraktik::class);
    }

    public function submission_mutasi()
    {
        return $this->hasOne(SubmissionMutasi::class);
    }

    public function submission_ppdgs()
    {
        return $this->hasOne(SubmissionPpdgs::class);
    }
}
