<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoCitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estado_citas')->insert([
            [
                'nombre' => 'PENDIENTE',
                'color' => '#f1c40f',
                'icono' => 'fa-solid fa-clock',
                'activo' => true,
                'created_at' => now(),
            ],
            [
                'nombre' => 'CONFIRMADA',
                'color' => '#2ecc71',
                'icono' => 'fa-solid fa-check',
                'activo' => true,
                'created_at' => now(),
            ],
            [
                'nombre' => 'CANCELADA',
                'color' => '#e74c3c',
                'icono' => 'fa-solid fa-xmark',
                'activo' => true,
                'created_at' => now(),
            ],
            [
                'nombre' => 'RECHAZADA',
                'color' => '#7f8c8d',
                'icono' => 'fa-solid fa-circle-xmark',
                'activo' => true,
                'created_at' => now(),
            ],
        ]);
    }
}
