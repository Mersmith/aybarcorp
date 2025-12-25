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
            'nombre' => 'Sede Central',
            'direccion' => 'Av. Principal 123, Lima',
            'activo' => true,
        ]);

        Sede::create([
            'nombre' => 'Sede Sur',
            'direccion' => 'Av. Los Héroes 890, San Juan de Miraflores',
            'activo' => true,
        ]);

        Sede::create([
            'nombre' => 'Sede Norte',
            'direccion' => 'Av. Tupac Amaru 770, Comas',
            'activo' => true,
        ]);
    }
}
