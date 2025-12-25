<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Canal;

class CanalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Canal::insert([
            ['nombre' => 'WhatsApp', 'activo' => true],
            ['nombre' => 'Web', 'activo' => true],
            ['nombre' => 'Call Center', 'activo' => true],
            ['nombre' => 'Presencial', 'activo' => true],
            ['nombre' => 'Email', 'activo' => true],
            ['nombre' => 'Facebook Messenger', 'activo' => true],
        ]);
    }
}
