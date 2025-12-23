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
            ['nombre' => 'Soporte Técnico', 'activo' => true],
            ['nombre' => 'Atención al Cliente', 'activo' => true],
            ['nombre' => 'Ventas', 'activo' => true],
            ['nombre' => 'Postventa', 'activo' => true],
            ['nombre' => 'Facturación', 'activo' => true],
            ['nombre' => 'Marketing', 'activo' => true],
        ]);
    }
}
