<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'alamat' => 'Jl. Contoh No.1, Jakarta Pusat',
            'iuran_at' => now(),
            'iuran_until' => now(),
            'handphone' => '081234567890',
        ]);
        $superadmin->assignRole ('superadmin');
        $superadmin->userDocument()->create([]);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'alamat' => 'Jl. Contoh No.1, Jakarta Pusat',
            'iuran_at' => now(),
            'iuran_until' => now(),
            'handphone' => '081234567890',
        ]);
        $admin->assignRole ('admin');
        $admin->userDocument()->create([]);

        $interview = User::create([
            'name' => 'interview',
            'email' => 'interview@interview.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Kristen',
            'alamat' => 'Jl. Contoh No.1, Jakarta Pusat',
            'iuran_at' => now(),
            'iuran_until' => now(),
            'handphone' => '081234567890',
        ]);
        $interview->assignRole ('interview');
        $interview->userDocument()->create([]);

        $bendahara = User::create([
            'name' => 'bendahara',
            'email' => 'bendahara@bendahara.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Katolik',
            'alamat' => 'Jl. Contoh No.1, Jakarta Pusat',
            'iuran_at' => now(),
            'iuran_until' => now(),
            'handphone' => '081234567890',
        ]);
        $bendahara->assignRole ('bendahara');
        $bendahara->userDocument()->create([]);

        $anggota = User::create([
            'name' => 'anggota',
            'email' => 'anggota@anggota.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Perempuan',
            'agama' => 'Buddha',
            'alamat' => 'Jl. Contoh No.1, Jakarta Pusat',
            'iuran_at' => now(),
            'iuran_until' => now(),
            'handphone' => '081234567890',
        ]);
        $anggota->assignRole ('anggota');
        $anggota->userDocument()->create([]);

        $user = User::create([
            'name' => 'user',
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Hindu',
            'alamat' => 'Jl. Contoh No.1, Jakarta Pusat',
            'iuran_at' => now(),
            'iuran_until' => now(),
            'handphone' => '081234567890',
        ]);
        $user->assignRole ('non-anggota');
        $user->userDocument()->create([]);
    }
}
