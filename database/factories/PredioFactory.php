<?php

namespace Database\Factories;

use App\Models\Oficina;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Predio>
 */
class PredioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $oficinas = Oficina::select('oficina')->pluck('oficina');

        return [
            'status' => 'activo',
            'exento' => fake()->boolean($chanceOfGettingTrue = 50),
            'estado' => 16,
            'region_catastral' => fake()->numberBetween(1,100),
            'municipio' => fake()->numberBetween(1,100),
            'zona_catastral' => fake()->numberBetween(1,100),
            'localidad' => fake()->numberBetween(1,100),
            'sector' => fake()->numberBetween(1,100),
            'manzana' => fake()->numberBetween(1,100),
            'predio' => fake()->numberBetween(1,10000),
            'edificio' => fake()->numberBetween(1,100),
            'departamento' => fake()->numberBetween(1,100),
            'oficina' => fake()->randomElement($oficinas),
            'tipo_predio' => fake()->numberBetween(1,2),
            'numero_registro' => fake()->numberBetween(1,100000),
            'tipo_vialidad' => fake()->word(),
            'tipo_asentamiento' => fake()->word(),
            'nombre_vialidad' => fake()->word(),
            'numero_exterior' => fake()->word(),
            'numero_exterior_2' => fake()->word(),
            'numero_adicional' => fake()->word(),
            'numero_adicional_2' => fake()->word(),
            'numero_interior' => fake()->word(),
            'nombre_asentamiento' => fake()->word(),
            'codigo_postal' => fake()->word(),
            'lote_fraccionador' => fake()->word(),
            'manzana_fraccionador' => fake()->word(),
            'etapa_fraccionador' => fake()->word(),
            'nombre_predio' => fake()->paragraph(),
            'nombre_edificio' => fake()->words(2, true),
            'clave_edificio' => fake()->words(2, true),
            'departamento_edificio' => fake()->words(2, true),
            'uso_1' => fake()->words(2, true),
            'uso_2' => fake()->words(2, true),
            'uso_3' => fake()->words(2, true),
            'ubicacion_en_manzana' => fake()->words(2, true),
            'superficie_total_terreno' => fake()->randomFloat(2, 50, 1000),
            'superficie_total_construccion' => fake()->randomFloat(2, 50, 1000),
            'superficie_judicial' => fake()->randomFloat(2, 50, 1000),
            'superficie_notarial' => fake()->randomFloat(2, 50, 1000),
            'area_comun_terreno' => fake()->randomFloat(2, 50,1000),
            'area_comun_construccion' => fake()->randomFloat(2, 50,1000),
            'valor_terreno_comun' => fake()->randomFloat(2, 1000, 100000),
            'valor_construccion_comun' => fake()->randomFloat(2, 1000, 10000),
            'valor_total_terreno' => fake()->randomFloat(2, 1000, 100000),
            'valor_total_construccion' => fake()->randomFloat(2, 1000, 10000),
            'lat' => '19.702423',
            'lon' => '-101.2304273',
            'valor_catastral' => function(array $attributes){
                return $attributes['tipo_predio'] == 1 ? fake()->randomFloat(2, 1, 10000000) : fake()->randomFloat(2, 1, 10000000);
            },
            'indexado_en' => fake()->dateTimeBetween(now()->subYear()->startOfYear(), now()->subYear()->endOfYear()),
            'fecha_efectos' => fake()->dateTimeBetween('1980-01-01', '2025-12-31')
        ];
    }

    public function oficina($oficina){

        return $this->state(fn (array $attrubutes) => [
            'oficina' => $oficina
        ]);

    }

}
