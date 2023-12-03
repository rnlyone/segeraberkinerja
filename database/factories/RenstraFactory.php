<?php

namespace Database\Factories;

use App\Models\SKPD;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Renstra>
 */
class RenstraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $skpdIds = SKPD::pluck('id')->toArray();
        return [
            'id_skpd' => fake()->randomElement($skpdIds),
            'periode' => fake()->year,
            'visi' => fake()->paragraph,
            'misi' => fake()->paragraph,
            'tujuan' => fake()->paragraph,
            'sasaran' => fake()->paragraph,
            'dokumen' => fake()->word . '.pdf', // Contoh nama dokumen

        ];
    }
}
