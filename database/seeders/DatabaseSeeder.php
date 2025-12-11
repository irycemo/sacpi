<?php

namespace Database\Seeders;

use Database\Seeders\UmaSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ValorSeeder;
use Database\Seeders\PredioSeeder;
use Database\Seeders\NotariaSeeder;
use Database\Seeders\OficinaSeeder;
use Database\Seeders\DescuentoSeeder;
use Database\Seeders\CuotaminimaSeeder;
use Database\Seeders\FactorIncrementoSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(OficinaSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(UmaSeeder::class);
        $this->call(NotariaSeeder::class);
        $this->call(FactorIncrementoSeeder::class);
        $this->call(ValorSeeder::class);
        $this->call(ParametroSeeder::class);
        $this->call(CuotaminimaSeeder::class);
        $this->call(PredioSeeder::class);
        $this->call(DescuentoSeeder::class);

    }
}
