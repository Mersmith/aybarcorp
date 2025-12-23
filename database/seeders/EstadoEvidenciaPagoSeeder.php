<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoEvidenciaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estado_evidencia_pagos')->insert([
            [
                'nombre' => 'PENDIENTE',
                'color' => '#FF9800',
                'icono' => 'fa-regular fa-clock',
                'activo' => true,
                'created_at' => now(),
            ],
            [
                'nombre' => 'OBSERVADO',
                'color' => '#9B59B6',
                'icono' => 'fa-solid fa-eye',
                'activo' => true,
                'created_at' => now(),
            ],
            [
                'nombre' => 'APROBADO',
                'color' => '#2ECC71',
                'icono' => 'fa-solid fa-circle-check',
                'activo' => true,
                'created_at' => now(),
            ],
            [
                'nombre' => 'RECHAZADO',
                'color' => '#E74C3C',
                'icono' => 'fa-solid fa-ban',
                'activo' => true,
                'created_at' => now(),
            ],
        ]);
    }
}
