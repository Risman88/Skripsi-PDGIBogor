<?php

namespace Database\Factories;

use App\Models\Slideshow;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slideshow>
 */
class SlideshowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_url' => 'images/banner/evc9VyzquXnLOA8lt45VwbJrfGBiXT8yoxmbneyQ.png',
            'caption' => '',
        ];
    }
}
