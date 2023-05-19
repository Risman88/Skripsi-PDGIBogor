<?php

namespace Database\Seeders;

use App\Models\SubmissionType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubmissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $submissionTypes = SubmissionType::create(['name' => 'Pengajuan Anggota']);
        $submissionTypes = SubmissionType::create(['name' => 'Pengajuan SRIP Non Anggota']);
        $submissionTypes = SubmissionType::create(['name' => 'Pengajuan SRIP Anggota Dokter Gigi']);
        $submissionTypes = SubmissionType::create(['name' => 'Pengajuan SRIP Anggota Dokter Gigi Spesialis']);
        $submissionTypes = SubmissionType::create(['name' => 'Pengajuan SPIP Anggota Dokter Gigi']);
        $submissionTypes = SubmissionType::create(['name' => 'Pengajuan SPIP Anggota Dokter Gigi Spesialis']);
        $submissionTypes = SubmissionType::create(['name' => 'Pengajuan Mutasi Anggota']);
        $submissionTypes = SubmissionType::create(['name' => 'Pengajuan PPDGS Anggota']);
    }
}
