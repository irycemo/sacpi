<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo' => fake()->randomElement(['FÍSICA', 'MORAL']),
            'nombre' => function(array $attributes){
                return $attributes['tipo'] == 'FÍSICA' ? fake()->words(2, true) : null;
            },
            'ap_paterno' => function(array $attributes){
                return $attributes['tipo'] == 'FÍSICA' ? fake()->lastName() : null;
            },
            'ap_materno' => function(array $attributes){
                return $attributes['tipo'] == 'FÍSICA' ? fake()->lastName() : null;
            },
            'razon_social' => function(array $attributes){
                return $attributes['tipo'] == 'MORAL' ? fake()->words(5, true) : null;
            },
        ];
    }
}
