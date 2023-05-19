<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubmissionIzinPraktik>
 */
class SubmissionIzinPraktikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'praktik_ke' => $this->faker->randomElement(['1', '2', '3']),
            'tujuan_surat' => $this->faker->randomElement(['Pembuatan SIP', 'Perpanjangan SIP', 'Pindah Alamat SIP']),
            'alumni_drg' => $this->faker->company,
            'tahun_lulus' => $this->faker->year,
            'str' => $this->faker->unique()->regexify('/^\d{2}\.\d{1}\.\d{1}\.\d{3}\.\d{1}\.\d{2}\.\d{6}$/'),
            'valid_str' => $this->faker->date(),
            'serkom' => $this->faker->unique()->numerify('SERKOM-#######'),
            'npa' => $this->faker->unique()->regexify('/^\d{4}\.\d{6}$/'),
            'cabang_pdgi' => $this->faker->city,
            'alamat_fakes1' => $this->faker->address,
            'jadwal_praktik1' => $this->faker->dayOfWeek,
            'surat_praktik1' => fake()->imageUrl($width=400, $height=400),
            'alamat_fakes2' => $this->faker->address,
            'jadwal_praktik2' => $this->faker->dayOfWeek,
            'surat_praktik2' => fake()->imageUrl($width=400, $height=400),
            'alamat_fakes3' => $this->faker->address,
            'jadwal_praktik3' => $this->faker->dayOfWeek,
            'surat_praktik3' => fake()->imageUrl($width=400, $height=400),
            'scan_serkom' => fake()->imageUrl($width=400, $height=400),
            'scan_str' => fake()->imageUrl($width=400, $height=400),
            'scan_surat_sehat' => fake()->imageUrl($width=400, $height=400),
            'scan_surat_pengantar' => fake()->imageUrl($width=400, $height=400),
            'scan_surat_kolegium' => fake()->imageUrl($width=400, $height=400),
        ];
    }
}
