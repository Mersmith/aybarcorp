<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaTipoSolicitudSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['area_id' => 1, 'tipo_solicitud_id' => 1],
            ['area_id' => 1, 'tipo_solicitud_id' => 2],
            ['area_id' => 1, 'tipo_solicitud_id' => 3],
            ['area_id' => 1, 'tipo_solicitud_id' => 4],
            ['area_id' => 1, 'tipo_solicitud_id' => 5],
            ['area_id' => 1, 'tipo_solicitud_id' => 6],
            ['area_id' => 1, 'tipo_solicitud_id' => 7],
            ['area_id' => 1, 'tipo_solicitud_id' => 8],
            ['area_id' => 1, 'tipo_solicitud_id' => 9],
            ['area_id' => 2, 'tipo_solicitud_id' => 10],
            ['area_id' => 2, 'tipo_solicitud_id' => 11],
            ['area_id' => 2, 'tipo_solicitud_id' => 12],
            ['area_id' => 3, 'tipo_solicitud_id' => 13],
            ['area_id' => 3, 'tipo_solicitud_id' => 14],
            ['area_id' => 4, 'tipo_solicitud_id' => 15],
            ['area_id' => 4, 'tipo_solicitud_id' => 16],
            ['area_id' => 4, 'tipo_solicitud_id' => 17],
        ];

        DB::table('area_tipo_solicitud')->insert($data);
    }
}
