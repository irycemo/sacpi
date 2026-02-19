<?php

namespace Database\Seeders;

use App\Models\Uma;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Uma::create([
            'año' => 2016,
            'diario' => 73.04,
            'mensual' => 2220.42,
            'anual' => 26645.04,
            'minimo_rustico' => null,
            'minimo_urbano' => null
        ]);

        Uma::create([
            'año' => 2017,
            'diario' => 75.49,
            'mensual' => 2294.90,
            'anual' => 27538.80,
            'minimo_rustico' => null,
            'minimo_urbano' => null
        ]);

        Uma::create([
            'año' => 2018,
            'diario' => 80.60,
            'mensual' => 2450.24,
            'anual' => 29402.88,
            'minimo_rustico' => null,
            'minimo_urbano' => null
        ]);

        Uma::create([
            'año' => 2019,
            'diario' => 84.49,
            'mensual' => 2568.50,
            'anual' => 30822.00,
            'minimo_rustico' => null,
            'minimo_urbano' => null
        ]);

        Uma::create([
            'año' => 2020,
            'diario' => 86.88,
            'mensual' => 2641.15,
            'anual' => 31693.80,
            'minimo_rustico' => null,
            'minimo_urbano' => null
        ]);

        Uma::create([
            'año' => 2021,
            'diario' => 89.62,
            'mensual' => 2724.45,
            'anual' => 32693.40,
            'minimo_rustico' => null,
            'minimo_urbano' => null
        ]);

        Uma::create([
            'año' => 2022,
            'diario' => 96.22,
            'mensual' => 2925.09,
            'anual' => 35101.08,
            'minimo_rustico' => null,
            'minimo_urbano' => null
        ]);

        Uma::create([
            'año' => 2023,
            'diario' => 103.74,
            'mensual' => 3153.70,
            'anual' => 37844.40,
            'minimo_rustico' => null,
            'minimo_urbano' => null
        ]);

        Uma::create([
            'año' => 2024,
            'diario' => 108.57,
            'mensual' => 3300.53,
            'anual' => 39606.36,
            'minimo_rustico' => 1303,
            'minimo_urbano' => 2714
        ]);

        Uma::create([
            'año' => 2025,
            'diario' => 113.14,
            'mensual' => 3439.46,
            'anual' => 41273.52,
            'minimo_rustico' => 2829,
            'minimo_urbano' => 1358
        ]);
    }
}
