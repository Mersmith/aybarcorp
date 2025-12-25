<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoSolicitud;

class TipoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoSolicitud::insert([
            [
                'id' => 1,
                'nombre' => 'Reclamo',
                'tiempo_solucion' => 72, // horas
                'activo' => true,
            ],
            [
                'id' => 2,
                'nombre' => 'Consulta',
                'tiempo_solucion' => 48,
                'activo' => true,
            ],
            [
                'id' => 3,
                'nombre' => 'Falla técnica',
                'tiempo_solucion' => 24,
                'activo' => true,
            ],
            [
                'id' => 4,
                'nombre' => 'Solicitud de información',
                'tiempo_solucion' => 48,
                'activo' => true,
            ],
            [
                'id' => 5,
                'nombre' => 'Garantía',
                'tiempo_solucion' => 72,
                'activo' => true,
            ],
            [
                'id' => 6,
                'nombre' => 'Queja',
                'tiempo_solucion' => 72,
                'activo' => true,
            ],
            [
                'id' => 7,
                'nombre' => 'Seguimiento de pedido',
                'tiempo_solucion' => 24,
                'activo' => true,
            ],
        ]);
    }
}
