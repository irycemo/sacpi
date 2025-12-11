<?php

namespace Database\Seeders;

use App\Models\Descuento;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DescuentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tipos = ['cuenta corriente', 'rezago', 'ambos'];
        $accesorios = ['impuesto', 'recargos', 'multas'];
        $porcentjaes = [10, 20, 30, 50, 75, 100];

        for ($i=0; $i < 3; $i++) {

            for ($j=0; $j < 3; $j++) {

                for ($k=0; $k < 6; $k++) {

                    Descuento::create([
                        'tipo' => $tipos[$i],
                        'porcentaje' => $porcentjaes[$k],
                        'accesorio' => $accesorios[$j],
                        'fecha_inicial' => '2025-01-01',
                        'fecha_final' => '2025-01-31',
                    ]);

                    Descuento::create([
                        'tipo' => $tipos[$i],
                        'porcentaje' => $porcentjaes[$k],
                        'accesorio' => $accesorios[$j],
                        'fecha_inicial' => '2025-12-01',
                        'fecha_final' => '2025-12-31',
                    ]);

                }

            }

        }/*

        $descuentos = Descuento::pluck('id');

        $oficinas = Oficina::with('descuentos:id')->select('id')->get();

        foreach($descuentos as $descuento){

            foreach($oficinas as $oficina){

                $oficina->descuentos()->attach($descuento, ['estado' => 'activo']);

            }

        } */

    }
}
