<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::insert([
            [
                'nombre' => 'ATC', // Atención al Cliente
                'color'  => '#3498db', // Azul: comunicación, soporte
                'icono'  => 'fa-solid fa-headset',
                'activo' => true
            ],
            [
                'nombre' => 'BACK OFFICE',
                'color'  => '#34495e', // Verde: procesos internos, operaciones
                'icono'  => 'fa-solid fa-gear',
                'activo' => true
            ],
            [
                'nombre' => 'LEGAL',
                'color'  => '#8e44ad', // Morado: autoridad, formalidad
                'icono'  => 'fa-solid fa-scale-balanced',
                'activo' => true
            ],
            [
                'nombre' => 'ARCHIVOS',
                'color'  => '#f39c12', // Naranja: almacenamiento, gestión documental
                'icono'  => 'fa-solid fa-folder-open',
                'activo' => true
            ],
        ]);
    }
}
