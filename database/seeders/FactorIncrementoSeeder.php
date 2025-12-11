<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactorIncrementoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('factor_incrementos')->delete();

        \DB::table('factor_incrementos')->insert(array (
            0 =>
            array (
                'id' => 1,
                'factor' => '1.19',
                'año' => 1980,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            1 =>
            array (
                'id' => 2,
                'factor' => '1.29',
                'año' => 1981,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            2 =>
            array (
                'id' => 3,
                'factor' => '1.29',
                'año' => 1982,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            3 =>
            array (
                'id' => 4,
                'factor' => '1.84',
                'año' => 1983,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            4 =>
            array (
                'id' => 5,
                'factor' => '1.92',
                'año' => 1984,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            5 =>
            array (
                'id' => 6,
                'factor' => '1.59',
                'año' => 1985,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            6 =>
            array (
                'id' => 7,
                'factor' => '1.60',
                'año' => 1986,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            7 =>
            array (
                'id' => 8,
                'factor' => '1.51',
                'año' => 1987,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            8 =>
            array (
                'id' => 9,
                'factor' => '1.81',
                'año' => 1988,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            9 =>
            array (
                'id' => 10,
                'factor' => '1.71',
                'año' => 1989,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            10 =>
            array (
                'id' => 11,
                'factor' => '1.18',
                'año' => 1990,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            11 =>
            array (
                'id' => 12,
                'factor' => '1.1972',
                'año' => 1991,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            12 =>
            array (
                'id' => 13,
                'factor' => '1.1972',
                'año' => 1992,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            13 =>
            array (
                'id' => 14,
                'factor' => '1.1296',
                'año' => 1993,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            14 =>
            array (
                'id' => 15,
                'factor' => '1.0871',
                'año' => 1994,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            15 =>
            array (
                'id' => 16,
                'factor' => '1.0693',
                'año' => 1995,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            16 =>
            array (
                'id' => 17,
                'factor' => '1.4846',
                'año' => 1996,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            17 =>
            array (
                'id' => 18,
                'factor' => '1.2777',
                'año' => 1997,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            18 =>
            array (
                'id' => 19,
                'factor' => '1.1777',
                'año' => 1998,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            19 =>
            array (
                'id' => 20,
                'factor' => '1.174',
                'año' => 1999,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            20 =>
            array (
                'id' => 21,
                'factor' => '1.1391',
                'año' => 2000,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            21 =>
            array (
                'id' => 22,
                'factor' => '1.0887',
                'año' => 2001,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            22 =>
            array (
                'id' => 23,
                'factor' => '1.0538',
                'año' => 2002,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            23 =>
            array (
                'id' => 24,
                'factor' => '1.0538',
                'año' => 2003,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            24 =>
            array (
                'id' => 25,
                'factor' => '1.0398',
                'año' => 2004,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            25 =>
            array (
                'id' => 26,
                'factor' => '1.0542',
                'año' => 2005,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            26 =>
            array (
                'id' => 27,
                'factor' => '1.0291',
                'año' => 2006,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            27 =>
            array (
                'id' => 28,
                'factor' => '1.0409',
                'año' => 2007,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            28 =>
            array (
                'id' => 29,
                'factor' => '1.0392',
                'año' => 2008,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            29 =>
            array (
                'id' => 30,
                'factor' => '1.0623',
                'año' => 2009,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            30 =>
            array (
                'id' => 31,
                'factor' => '1.0386',
                'año' => 2010,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            31 =>
            array (
                'id' => 32,
                'factor' => '1.0431',
                'año' => 2011,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            32 =>
            array (
                'id' => 33,
                'factor' => '1.0348',
                'año' => 2012,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            33 =>
            array (
                'id' => 34,
                'factor' => '1.0418',
                'año' => 2013,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            34 =>
            array (
                'id' => 35,
                'factor' => '1.0362',
                'año' => 2014,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            35 =>
            array (
                'id' => 36,
                'factor' => '1.0417',
                'año' => 2015,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            36 =>
            array (
                'id' => 37,
                'factor' => '1.0221',
                'año' => 2016,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            37 =>
            array (
                'id' => 38,
                'factor' => '1.033',
                'año' => 2017,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            38 =>
            array (
                'id' => 39,
                'factor' => '1.0663',
                'año' => 2018,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            39 =>
            array (
                'id' => 40,
                'factor' => '1.0471',
                'año' => 2019,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            40 =>
            array (
                'id' => 41,
                'factor' => '1.0297',
                'año' => 2020,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            41 =>
            array (
                'id' => 42,
                'factor' => '1.0333',
                'año' => 2021,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            42 =>
            array (
                'id' => 43,
                'factor' => '1.0737',
                'año' => 2022,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            43 =>
            array (
                'id' => 44,
                'factor' => '1.0779',
                'año' => 2023,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
            44 =>
            array (
                'id' => 45,
                'factor' => '1.0432',
                'año' => 2024,
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2024-01-25 13:02:31',
                'updated_at' => '2024-01-25 13:02:31',
            ),
        ));
    }
}
