<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('bank_accounts')->insert([
            'nama_bank' => 'BCA',
            'nomor_rekening' => '7380537707',
            'nama_rekening' => 'Rini Utari Anggraeni, drg',
        ]);
    }
}
