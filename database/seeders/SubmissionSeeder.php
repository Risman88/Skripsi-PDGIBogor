<?php

namespace Database\Seeders;

use App\Models\Submission;
use App\Models\SubmissionPpdgs;
use Illuminate\Database\Seeder;
use App\Models\SubmissionMutasi;
use App\Models\SubmissionAnggota;
use App\Models\SubmissionIzinPraktik;
use App\Models\Payments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat data submission untuk Submission Type 1 (Anggota)
        for ($i = 0; $i < 5; $i++) {
            $submission = Submission::factory()->create(['submission_type_id' => 1]);
            $submissionAnggota = SubmissionAnggota::factory()->make();
            $submission->submission_anggota()->save($submissionAnggota);
            $payment = new Payments([
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
                'jenis_pembayaran'=> 'Pengajuan Anggota dan Pembayaran Iuran 1 Tahun dengan ID Pengajuan  ' . $submission->id,
                'jangka_iuran'=> 365,
                'jumlah_pembayaran' =>400000,
                'bank_account_id' => 1,
                'status' => 'Belum dibayar',
            ]);
            $payment->save();
        }

        // Membuat data submission untuk Submission Type 2 (Izin Praktek)
        // Pastikan sudah membuat factory untuk submission$submissionIzinPraktik
        for ($i = 0; $i < 5; $i++) {
            $submission = Submission::factory()->create(['submission_type_id' => 2]);
            $submissionIzinPraktik = SubmissionIzinPraktik::factory()->make();
            $submission->submission_izin_praktik()->save($submissionIzinPraktik);
            $payment = new Payments([
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
                'jenis_pembayaran'=> 'Pengajuan SRIP Non-Anggota dengan ID Pengajuan ' . $submission->id,
                'jumlah_pembayaran' =>400000,
                'bank_account_id' => 1,
                'status' => 'Belum dibayar',
            ]);
            $payment->save();
        }

        for ($i = 0; $i < 5; $i++) {
            $submission = Submission::factory()->create(['submission_type_id' => 3]);
            $submissionIzinPraktik = SubmissionIzinPraktik::factory()->make();
            $submission->submission_izin_praktik()->save($submissionIzinPraktik);
            $payment = new Payments([
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
                'jenis_pembayaran'=> 'Pengajuan SRIP Anggota Drg dengan ID Pengajuan ' . $submission->id,
                'jumlah_pembayaran' =>150000,
                'bank_account_id' => 1,
                'status' => 'Belum dibayar',
            ]);
            $payment->save();
        }

        for ($i = 0; $i < 5; $i++) {
            $submission = Submission::factory()->create(['submission_type_id' => 4]);
            $submissionIzinPraktik = SubmissionIzinPraktik::factory()->make();
            $submission->submission_izin_praktik()->save($submissionIzinPraktik);
            $payment = new Payments([
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
                'jenis_pembayaran'=> 'Pengajuan SRIP Anggota Drg Spesialis dengan ID Pengajuan ' . $submission->id,
                'jumlah_pembayaran' =>300000,
                'bank_account_id' => 1,
                'status' => 'Belum dibayar',
            ]);
            $payment->save();
        }

        for ($i = 0; $i < 5; $i++) {
            $submission = Submission::factory()->create(['submission_type_id' => 5]);
            $submissionIzinPraktik = SubmissionIzinPraktik::factory()->make();
            $submission->submission_izin_praktik()->save($submissionIzinPraktik);
            $payment = new Payments([
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
                'jenis_pembayaran'=> 'Pengajuan SPIP Anggota Drg dengan ID Pengajuan ' . $submission->id,
                'jumlah_pembayaran' =>100000,
                'bank_account_id' => 1,
                'status' => 'Belum dibayar',
            ]);
            $payment->save();
        }

        for ($i = 0; $i < 5; $i++) {
            $submission = Submission::factory()->create(['submission_type_id' => 6]);
            $submissionIzinPraktik = SubmissionIzinPraktik::factory()->make();
            $submission->submission_izin_praktik()->save($submissionIzinPraktik);
            $payment = new Payments([
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
                'jenis_pembayaran'=> 'Pengajuan SPIP Anggota Drg dengan ID Pengajuan ' . $submission->id,
                'jumlah_pembayaran' =>250000,
                'bank_account_id' => 1,
                'status' => 'Belum dibayar',
            ]);
            $payment->save();
        }
        // Membuat data submission untuk Submission Type 3 (Mutasi)
        // Pastikan sudah membuat factory untuk SubmissionMutasi
        for ($i = 0; $i < 5; $i++) {
            $submission = Submission::factory()->create(['submission_type_id' => 7]);
            $submissionMutasi = SubmissionMutasi::factory()->make();
            $submission->submission_mutasi()->save($submissionMutasi);
            $payment = new Payments([
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
                'jenis_pembayaran'=> 'Pengajuan Surat Mutasi dengan ID Pengajuan ' . $submission->id,
                'jumlah_pembayaran' =>100000,
                'bank_account_id' => 1,
                'status' => 'Belum dibayar',
            ]);
            $payment->save();
        }

        for ($i = 0; $i < 5; $i++) {
            $submission = Submission::factory()->create(['submission_type_id' => 8]);
            $submissionPpdgs = SubmissionPpdgs::factory()->make();
            $submission->submission_ppdgs()->save($submissionPpdgs);
            $payment = new Payments([
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
                'jenis_pembayaran'=> 'Pengajuan Surat PPDGS dengan ID Pengajuan ' . $submission->id,
                'jumlah_pembayaran' =>100000,
                'bank_account_id' => 1,
                'status' => 'Belum dibayar',
            ]);
            $payment->save();
        }

    }
}
