<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Area;

class AreaUserSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todas las áreas
        $areas = Area::pluck('id')->toArray();

        // Obtener solo usuarios admin
        $admins = User::where('rol', 'admin')->pluck('id')->toArray();

        foreach ($admins as $adminId) {
            // Elegir entre 1 y 3 áreas aleatorias
            $areasAsignadas = collect($areas)->random(rand(1, min(6, count($areas))));

            foreach ($areasAsignadas as $areaId) {
                DB::table('area_user')->insert([
                    'area_id' => $areaId,
                    'user_id' => $adminId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
