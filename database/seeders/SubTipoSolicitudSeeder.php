<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubTipoSolicitud;

class SubTipoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubTipoSolicitud::insert([
            // -------------------------
            // Reclamo (id = 1)
            // -------------------------
            [
                'tipo_solicitud_id' => 1,
                'nombre' => 'Reclamo por facturación',
                'tiempo_solucion' => 48,
                'activo' => true,
            ],
            [
                'tipo_solicitud_id' => 1,
                'nombre' => 'Reclamo por atención',
                'tiempo_solucion' => null, // hereda 72h
                'activo' => true,
            ],

            // -------------------------
            // Consulta (id = 2)
            // -------------------------
            [
                'tipo_solicitud_id' => 2,
                'nombre' => 'Consulta general',
                'tiempo_solucion' => null,
                'activo' => true,
            ],
            [
                'tipo_solicitud_id' => 2,
                'nombre' => 'Consulta contractual',
                'tiempo_solucion' => 72,
                'activo' => true,
            ],

            // -------------------------
            // Falla técnica (id = 3)
            // -------------------------
            [
                'tipo_solicitud_id' => 3,
                'nombre' => 'Falla crítica',
                'tiempo_solucion' => 12,
                'activo' => true,
            ],
            [
                'tipo_solicitud_id' => 3,
                'nombre' => 'Falla leve',
                'tiempo_solucion' => null,
                'activo' => true,
            ],

            // -------------------------
            // Garantía (id = 5)
            // -------------------------
            [
                'tipo_solicitud_id' => 5,
                'nombre' => 'Garantía por defecto de fábrica',
                'tiempo_solucion' => 96,
                'activo' => true,
            ],
        ]);
    }
}
