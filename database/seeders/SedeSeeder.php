<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sede;

class SedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sede::create([
            'nombre' => 'Panorama',
            'direccion' => 'Av. Principal 123, Lima',
            'activo' => true,
        ]);

        Sede::create([
            'nombre' => 'Credilotes',
            'direccion' => 'Javier Prado',
            'activo' => true,
        ]);
    }
}
