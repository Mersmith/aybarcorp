<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Area;
use App\Models\TipoSolicitud;

class AreaTipoSolicitudSeeder extends Seeder
{
    public function run(): void
    {
        $areas = Area::pluck('id')->toArray();
        $tipos = TipoSolicitud::pluck('id')->toArray();

        foreach ($areas as $areaId) {

            // Seleccionar entre 1 y N tipos de solicitud aleatorios
            $cantidad = rand(1, min(7, count($tipos)));

            $tiposAleatorios = collect($tipos)->random($cantidad);

            foreach ($tiposAleatorios as $tipoId) {
                DB::table('area_tipo_solicitud')->insert([
                    'area_id' => $areaId,
                    'tipo_solicitud_id' => $tipoId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
