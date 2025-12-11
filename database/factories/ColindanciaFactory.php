<?php

namespace Database\Factories;

use App\Constantes\Constantes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Colindancia>
 */
class ColindanciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'viento' => fake()->randomElement(Constantes::VIENTOS),
            'longitud' => fake()->randomFloat(2, 10, 100),
            'descripcion' => fake()->text()
        ];
    }
}
