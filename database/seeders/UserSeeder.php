<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Enrique Robledo Camacho',
            'status' => 'activo',
            'email' => 'enrique_j_@hotmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Jesus Manriquez Vargas',
            'status' => 'activo',
            'email' => 'subdirti.irycem@correo.michoacan.gob.mx',
            'password' => bcrypt('12345678'),
        ])->assignRole('Administrador');

    }
}
