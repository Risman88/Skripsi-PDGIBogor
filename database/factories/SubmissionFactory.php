<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(2, 5),
            'submission_type_id' => $this->faker->numberBetween(1, 8),
            'status' => $this->faker->randomElement(['Diproses', 'Ditolak']),
            'surat_keluar' => $this->faker->imageUrl(400, 400),
        ];
    }
}
