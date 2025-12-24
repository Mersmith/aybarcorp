<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesYPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ----------------------------------------
        // 1. LISTA DE PERMISOS DEL SISTEMA
        // ----------------------------------------
        $permisos = [
            'estado-evidencia-pago-ver',
            'estado-evidencia-pago-crear',
            'estado-evidencia-pago-editar',
            'estado-evidencia-pago-eliminar',
            'evidencia-pago-ver',
            'evidencia-pago-crear',
            'evidencia-pago-editar',
            'evidencia-pago-eliminar',
            'evidencia-pago-validar',           
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // ----------------------------------------
        // 2. CREAR ROLES
        // ----------------------------------------
        $roles = [
            'super-admin',
            'supervisor gestor',
            'gestor',
            'cliente',
        ];

        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }

        // Obtener instancias
        $superAdmin = Role::findByName('super-admin');
        $supervisorGestor = Role::findByName('supervisor gestor');
        $gestor = Role::findByName('gestor');
        $cliente = Role::findByName('cliente');

        // ----------------------------------------
        // 3. ASIGNACIÓN DE PERMISOS POR ROL
        // ----------------------------------------
        $superAdmin->syncPermissions(Permission::all());

        $supervisorGestor->givePermissionTo([
            'estado-evidencia-pago-ver',
            'estado-evidencia-pago-crear',
            'estado-evidencia-pago-editar',
            'estado-evidencia-pago-eliminar',
            'evidencia-pago-eliminar',
            'evidencia-pago-validar',
        ]);

        $gestor->givePermissionTo([
            'evidencia-pago-ver',
            'evidencia-pago-crear',
            'evidencia-pago-editar',
        ]);      
    }
}
