<?php

use App\Models\Factura;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('rezagos', function(){

    $años = ['2021', '2022', '2023', '2024'];

    for($j = 0; $j < 4; $j++){

        for($i = 1; $i < 7; $i++){

            Factura::create([
                'predio_id' => 142,
                'status' => 'rezago',
                'ejercicio_fiscal' => $años[$j],
                'cuota' => 'superior',
                'bimestre' => $i,
                'total' => 550
            ]);

        }

    }

});