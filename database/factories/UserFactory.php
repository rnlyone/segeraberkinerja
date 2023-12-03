<?php

namespace Database\Factories;

use App\Models\SKPD;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'name' => fake()->name,
            'id_skpd' => fake()->randomElement($skpdIds),
            'level_user' => fake()->numberBetween(1, 5),
            'username' => fake()->userName,
            'email' => fake()->unique()->safeEmail,
            'email_verified_at' => now(),
            'no_hp' => fake()->phoneNumber,
            'password' => bcrypt('password'), // Anda dapat mengubahnya sesuai kebutuhan
            'profile_pict' => fake()->imageUrl(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
