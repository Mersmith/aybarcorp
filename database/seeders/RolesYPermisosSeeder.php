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
            'tipo-solicitud-ver',
            'tipo-solicitud-crear',
            'tipo-solicitud-editar',
            'tipo-solicitud-eliminar',
            'prioridad-ticket-ver',
            'prioridad-ticket-crear',
            'prioridad-ticket-editar',
            'prioridad-ticket-eliminar',
            'estado-ticket-ver',
            'estado-ticket-crear',
            'estado-ticket-editar',
            'estado-ticket-eliminar',
            'canal-ver',
            'canal-crear',
            'canal-editar',
            'canal-eliminar',
            'ticket-ver',
            'ticket-crear',
            'ticket-editar',
            'ticket-eliminar',
            'ticket-derivar-ver',
            'ticket-reporte-ver',
            'ticket-validar',
            /* */
            'motivo-cita-ver',
            'motivo-cita-crear',
            'motivo-cita-editar',
            'motivo-cita-eliminar',
            'estado-cita-ver',
            'estado-cita-crear',
            'estado-cita-editar',
            'estado-cita-eliminar',
            'cita-ver',
            'cita-crear',
            'cita-editar',
            'cita-eliminar',
            'calendario-ver',
            'cita-reporte-ver',
            'cita-validar',
            /* */
            'estado-evidencia-pago-ver',
            'estado-evidencia-pago-crear',
            'estado-evidencia-pago-editar',
            'estado-evidencia-pago-eliminar',
            'evidencia-pago-ver',
            'evidencia-pago-crear',
            'evidencia-pago-editar',
            'evidencia-pago-eliminar',
            'evidencia-pago-validar',
            'evidencia-pago-reporte-ver',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // ----------------------------------------
        // 2. CREAR ROLES
        // ----------------------------------------
        $roles = [
            'super-admin',
            'admin',
            'supervisor-atc',
            'asesor-atc',
            'supervisor-backoffice',
            'asesor-backoffice',
            'supervisor-legal',
            'asesor-legal',
            'supervisor-archivo',
            'asesor-archivo',
        ];

        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }

        // Obtener instancias
        $super_admin = Role::findByName('super-admin');
        $admin = Role::findByName('admin');

        $supervisor_atc = Role::findByName('supervisor-atc');
        $atc = Role::findByName('asesor-atc');

        $supervisor_backoffice = Role::findByName('supervisor-backoffice');
        $backoffice = Role::findByName('asesor-backoffice');

        // ----------------------------------------
        // 3. ASIGNACIÓN DE PERMISOS POR ROL
        // ----------------------------------------
        $super_admin->syncPermissions(Permission::all());
        $admin->syncPermissions(Permission::all());

        $supervisor_atc->givePermissionTo([
            'tipo-solicitud-ver',
            'tipo-solicitud-crear',
            'tipo-solicitud-editar',
            'tipo-solicitud-eliminar',
            'prioridad-ticket-ver',
            'prioridad-ticket-crear',
            'prioridad-ticket-editar',
            'prioridad-ticket-eliminar',
            'estado-ticket-ver',
            'estado-ticket-crear',
            'estado-ticket-editar',
            'estado-ticket-eliminar',
            'canal-ver',
            'canal-crear',
            'canal-editar',
            'canal-eliminar',

            'ticket-reporte-ver',
            'ticket-validar',
            /* */
            'motivo-cita-ver',
            'motivo-cita-crear',
            'motivo-cita-editar',
            'motivo-cita-eliminar',
            'estado-cita-ver',
            'estado-cita-crear',
            'estado-cita-editar',
            'estado-cita-eliminar',
            'cita-reporte-ver',
            'cita-validar',
            /* */
            'evidencia-pago-reporte-ver',
            'evidencia-pago-validar',
        ]);

        $atc->givePermissionTo([
            'ticket-ver',
            'ticket-crear',
            'ticket-editar',
            'ticket-eliminar',
            'ticket-derivar-ver',
            /* */
            'cita-ver',
            'cita-crear',
            'cita-editar',
            'cita-eliminar',
            'calendario-ver',
        ]);

        $supervisor_backoffice->givePermissionTo([
            'estado-evidencia-pago-ver',
            'estado-evidencia-pago-crear',
            'estado-evidencia-pago-editar',
            'estado-evidencia-pago-eliminar',
            'evidencia-pago-reporte-ver',
            'evidencia-pago-eliminar',
            'evidencia-pago-validar',
        ]);

        $backoffice->givePermissionTo([
            'evidencia-pago-ver',
            'evidencia-pago-crear',
            'evidencia-pago-editar',
        ]);
    }
}
