<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role1 = Rol::create(['name' => 'Administrador']);

        Permiso::create(['name' => 'Lista de roles', 'area' => 'Roles'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Crear rol', 'area' => 'Roles'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Editar rol', 'area' => 'Roles'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Borrar rol', 'area' => 'Roles'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Lista de permisos', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Crear permiso', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Editar permiso', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Borrar permiso', 'area' => 'Permisos'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Lista de usuarios', 'area' => 'Usuarios'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Crear usuario', 'area' => 'Usuarios'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Editar usuario', 'area' => 'Usuarios'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Borrar usuario', 'area' => 'Usuarios'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Editar permisos', 'area' => 'Usuarios'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Lista de oficinas', 'area' => 'Oficinas'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Crear oficina', 'area' => 'Oficinas'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Editar oficina', 'area' => 'Oficinas'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Borrar oficina', 'area' => 'Oficinas'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Lista de descuentos', 'area' => 'Descuentos'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Crear descuento', 'area' => 'Descuentos'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Editar descuento', 'area' => 'Descuentos'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Borrar descuento', 'area' => 'Descuentos'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Lista de valores', 'area' => 'Valores'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Lista de umas', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Crear uma', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Editar uma', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Borrar uma', 'area' => 'Valores'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Lista de factor incremento', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Crear factor incremento', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Editar factor incremento', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Borrar factor incremento', 'area' => 'Valores'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Valores generales', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Crear valor', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Editar valor', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Borrar valor', 'area' => 'Valores'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Cuotas minimas', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Crear cuota', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Editar cuota', 'area' => 'Valores'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Borrar cuota', 'area' => 'Valores'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Lista de predios', 'area' => 'Padrón Catastral'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Captura al padron', 'area' => 'Padrón Catastral'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Ver predio', 'area' => 'Padrón Catastral'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Área de consultas', 'area' => 'Consulta'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Ver oficina', 'area' => 'Consulta'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Ver reportes', 'area' => 'Consulta'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Consulta Padrón', 'area' => 'Consulta'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Cobro Predial', 'area' => 'Cobros'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Cobro ISAI', 'area' => 'Cobros'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Cancelar cobro predial', 'area' => 'Cobros'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Cancelar ISAI', 'area' => 'Cobros'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Consultar Traslados', 'area' => 'Traslados de dominio'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Corte de caja', 'area' => 'Reportes'])->syncRoles([$role1]);

        Permiso::create(['name' => 'Área de procesos', 'area' => 'Procesos'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Constancias', 'area' => 'Procesos'])->syncRoles([$role1]);
        Permiso::create(['name' => 'Generar requerimiento', 'area' => 'Procesos'])->syncRoles([$role1]);


        Permiso::create(['name' => 'Logs', 'area' => 'Logs'])->syncRoles([$role1]);

    }
}
