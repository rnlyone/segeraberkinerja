<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SKPD>
 */
class SKPDFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama_skpd' => fake()->sentence(2),
            'foto_skpd' => fake()->imageUrl(),
            'level_otoritas' => fake()->numberBetween(1, 5),
        ];
    }
}
