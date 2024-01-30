<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    protected static function booted()
    {
        static::deleting(function ($payment) {
            // Hapus submission terkait jika ada
            if ($payment->submission) {
                $submission = $payment->submission;

                // Hapus file surat keluar dari penyimpanan S3 jika ada
                $suratKeluarPath = $submission->surat_keluar;
                if (!empty($suratKeluarPath)) {
                    Storage::disk('s3')->delete($suratKeluarPath);
                }

                switch ($submission->submission_type_id) {
                    case 1:
                        // Hapus file-file terkait SubmissionAnggota dari penyimpanan S3
                        $submissionAnggota = SubmissionAnggota::where('submission_id', $submission->id)->first();
                        $scanFiles = [
                            'scan_serkom',
                            'scan_str',
                            'scan_mutasi',
                        ];

                        foreach ($scanFiles as $scanFile) {
                            $fileToDelete = $submissionAnggota->$scanFile;
                            if (!empty($fileToDelete)) {
                                Storage::disk('s3')->delete($fileToDelete);
                            }
                        }

                        $submissionAnggota->delete();
                        break;
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                    case 6:
                        // Hapus file-file terkait SubmissionIzinPraktik dari penyimpanan S3
                        $submissionIzinPraktik = SubmissionIzinPraktik::where('submission_id', $submission->id)->first();
                        $scanFiles = [
                            'surat_praktik1',
                            'surat_praktik2',
                            'surat_praktik3',
                            'scan_serkom',
                            'scan_str',
                            'scan_surat_sehat',
                            'scan_surat_kolegium',
                            'scan_surat_pengantar',
                            'surat_mkekg',
                        ];

                        foreach ($scanFiles as $scanFile) {
                            $fileToDelete = $submissionIzinPraktik->$scanFile;
                            if (!empty($fileToDelete)) {
                                Storage::disk('s3')->delete($fileToDelete);
                            }
                        }

                        $submissionIzinPraktik->delete();
                        break;
                }

                $submission->delete();
            }
        });
    }
}
