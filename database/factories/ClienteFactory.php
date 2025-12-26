<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'nombre' => $this->faker->name(),
            'dni' => $this->faker->unique()->numerify('########'),

            'telefono_principal' => $this->faker->phoneNumber(),
            'telefono_alternativo' => $this->faker->optional()->phoneNumber(),

            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
