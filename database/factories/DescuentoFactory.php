<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Descuento>
 */
class DescuentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo' => 'cuenta corriente',
            'accesorio' => 'impuesto',
            'fecha_inicial' => '2025-01-01',
            'fecha_final' => '2025-01-01',
        ];
    }
}
