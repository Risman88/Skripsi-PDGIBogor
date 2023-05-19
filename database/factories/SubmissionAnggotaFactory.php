<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubmissionAnggota>
 */
class SubmissionAnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'str' => $this->faker->unique()->regexify('/^\d{2}\.\d{1}\.\d{1}\.\d{3}\.\d{1}\.\d{2}\.\d{6}$/'),
            'serkom' => $this->faker->unique()->numerify('SERKOM-#######'),
            'cabang_mutasi' => $this->faker->optional()->company,
            'scan_str' => fake()->imageUrl($width=400, $height=400),
            'scan_serkom' => fake()->imageUrl($width=400, $height=400),
            'scan_mutasi' => fake()->imageUrl($width=400, $height=400),
        ];
    }
}
