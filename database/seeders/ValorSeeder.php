<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Valor;

class ValorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Valor::create([
            'ejercicio_fiscal' => 2021,
            'valor_catastral_minimo_urbanos' => 2594,
            'valor_catastral_minimo_rusticos' => 1245,
            'inpc_enero' => 110.210,
            'inpc_febrero' => 110.907,
            'inpc_marzo' => 111.824,
            'inpc_abril' => 112.190,
            'inpc_mayo' => 112.419,
            'inpc_junio' => 113.018,
            'inpc_julio' => 113.682,
            'inpc_agosto' => 113.899,
            'inpc_septiembre' => 114.601,
            'inpc_octubre' => 115.561,
            'inpc_noviembre' => 116.884,
            'inpc_diciembre' => 117.308,
        ]);

        Valor::create([
            'ejercicio_fiscal' => 2022,
            'valor_catastral_minimo_urbanos' => 2594,
            'valor_catastral_minimo_rusticos' => 1245,
            'inpc_enero' => 118.002,
            'inpc_febrero' => 118.981,
            'inpc_marzo' => 120.159,
            'inpc_abril' => 120.809,
            'inpc_mayo' => 121.022,
            'inpc_junio' => 122.044,
            'inpc_julio' => 122.948,
            'inpc_agosto' => 123.803,
            'inpc_septiembre' => 124.571,
            'inpc_octubre' => 125.276,
            'inpc_noviembre' => 125.997,
            'inpc_diciembre' => 126.478,
        ]);

        Valor::create([
            'ejercicio_fiscal' => 2023,
            'valor_catastral_minimo_urbanos' => 2594,
            'valor_catastral_minimo_rusticos' => 1245,
            'inpc_enero' => 127.336,
            'inpc_febrero' => 128.046,
            'inpc_marzo' => 128.289,
            'inpc_abril' => 128.363,
            'inpc_mayo' => 128.363,
            'inpc_junio' => 128.214,
            'inpc_julio' => 128.832,
            'inpc_agosto' => 129.545,
            'inpc_septiembre' => 130.120,
            'inpc_octubre' => 130.609,
            'inpc_noviembre' => 131.445,
            'inpc_diciembre' => 132.373,
        ]);


        Valor::create([
            'ejercicio_fiscal' => 2024,
            'valor_catastral_minimo_urbanos' => 2594,
            'valor_catastral_minimo_rusticos' => 1245,
            'inpc_enero' => 133.555,
            'inpc_febrero' => 133.681,
            'inpc_marzo' => 134.065,
            'inpc_abril' => 134.336,
            'inpc_mayo' => 134.336,
            'inpc_junio' => 134.594,
            'inpc_julio' => 136.003,
            'inpc_agosto' => 136.013,
            'inpc_septiembre' => 136.080,
            'inpc_octubre' => 136.828,
            'inpc_noviembre' => 137.424,
            'inpc_diciembre' => 137.949,
        ]);

        Valor::create([
            'ejercicio_fiscal' => 2025,
            'valor_catastral_minimo_urbanos' => 2594,
            'valor_catastral_minimo_rusticos' => 1245,
            'inpc_enero' => 138.343,
            'inpc_febrero' => 138.726,
            'inpc_marzo' => 139.161,
            'inpc_abril' => 139.620,
            'inpc_mayo' => 140.012,
            'inpc_junio' => 140.405,
            'inpc_julio' => 140.780,
            'inpc_agosto' => 140.780,
            'inpc_septiembre' => 140.780,
            'inpc_octubre' => 141.708,
            'inpc_noviembre' => 142.645,
            'inpc_diciembre' => 142.645,
        ]);
    }
}
