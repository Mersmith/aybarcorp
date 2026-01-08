<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EvidenciaPago>
 */
class EvidenciaPagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'observacion' => $this->faker->sentence(3),

            'codigo_cliente' => $this->faker->unique()->numerify('########'),
            'razon_social' => $this->faker->name(),
            'nombre_proyecto' => $this->faker->sentence(2),
            'etapa' => $this->faker->sentence(1),
            'manzana' => $this->faker->sentence(1),
        ];
    }
}
