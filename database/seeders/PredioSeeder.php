<?php

namespace Database\Seeders;

use App\Models\Predio;
use App\Models\Colindancia;
use App\Models\Propietario;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PredioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Predio::factory(100)
                ->has(Colindancia::factory(4))
                ->has(Propietario::factory())
                ->create();


        Predio::factory(50)
                ->oficina(101)
                ->has(Colindancia::factory(4))
                ->has(Propietario::factory())
                ->create();

    }
}
