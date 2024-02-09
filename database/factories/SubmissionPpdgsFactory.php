<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubmissionPpdgs>
 */
class SubmissionPpdgsFactory extends Factory
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
            'nama_univ' => $this->faker->text(40),
        ];
    }
}
