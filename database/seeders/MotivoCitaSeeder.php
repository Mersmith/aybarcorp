<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotivoCitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('motivo_citas')->insert([
            [
                'nombre' => 'Asesoría',
                'color' => '#3498db',
                'icono' => 'fa-solid fa-handshake',
                'activo' => true,
                'created_at' => now(),
            ],
            [
                'nombre' => 'Reclamo',
                'color' => '#e74c3c',
                'icono' => 'fa-solid fa-triangle-exclamation',
                'activo' => true,
                'created_at' => now(),
            ],
            [
                'nombre' => 'Revisión de documentos',
                'color' => '#9b59b6',
                'icono' => 'fa-solid fa-file-signature',
                'activo' => true,
                'created_at' => now(),
            ],
            [
                'nombre' => 'Reunión de avance',
                'color' => '#2ecc71',
                'icono' => 'fa-solid fa-chart-line',
                'activo' => true,
                'created_at' => now(),
            ],
            [
                'nombre' => 'Consulta general',
                'color' => '#1abc9c',
                'icono' => 'fa-solid fa-circle-question',
                'activo' => true,
                'created_at' => now(),
            ],
        ]);
    }
}
