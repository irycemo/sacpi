<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'clave' => 1,
            'name' => 'Enrique',
            'oficina_id' => '53',
            'status' => 'activo',
            'email' => 'enrique_j_@hotmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 2,
            'name' => 'Tomas',
            'oficina_id' => '53',
            'status' => 'activo',
            'email' => 'tomas.hernandez@plancartemorelia.edu.mx',
            'password' => bcrypt('12345678'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 4,
            'name' => 'Mauricio',
            'oficina_id' => '53',
            'status' => 'activo',
            'email' => 'mlanda64@hotmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 12,
            'oficina_id' => '53',
            'name' => 'Jesus Manriquez Vargas',
            'status' => 'activo',
            'email' => 'subdirti.irycem@correo.michoacan.gob.mx',
            'password' => Hash::make('sistema'),
        ])->assignRole('Administrador');



    }
}
