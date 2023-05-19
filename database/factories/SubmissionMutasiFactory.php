<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubmissionMutasi>
 */
class SubmissionMutasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'npa' => $this->faker->unique()->regexify('/^\d{4}\.\d{6}$/'),
            'mutasi_ke' => $this->faker->city,
            'alasan_mutasi' => $this->faker->text,
        ];
    }
}
