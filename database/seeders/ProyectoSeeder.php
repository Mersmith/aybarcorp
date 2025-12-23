<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Proyecto;
use Illuminate\Support\Str;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nombres_1 = [
            'ALTOS DEL PRADO',
            'ALTOS DEL VALLE',
            'CIUDAD DIAGONAL',
            'GREEN VIEW',
            'JUMEIRAH LAKE',
            'LA CALERA',
            'LA RESERVA DE HUARAL',
            'LACHAY VIEW',
            'LAGOON CENTER',
            'LAGOON VILLAGE',
            'LUGO',
            'ORENSE',
            'PLANICIE DE HUARAL',
            'PRAGA VILLAGE',
            'RIVERA DEL CAMPO',
            'SAN ANDRES',
            'URBAN RESIDENCIAL',
            'VILLA DEL PALMAR',
            'VILLA ENCANTADA',
            'VILLA PORTON',
            'VILLA PRIVADA COSTA VERDE',
            'VILLA PRIVADA VIDANTA',
        ];

        foreach ($nombres_1 as $nombre) {
            Proyecto::factory()->create([
                'unidad_negocio_id' => 1,
                'grupo_proyecto_id' => 1,
                'nombre' => $nombre,
                'slug' => Str::slug($nombre),
            ]);
        }

        $nombres_2 = [
            'FINCA MONTECARLO',
            'FORESTA',
            'PONTEVEDRA',
        ];

        foreach ($nombres_2 as $nombre) {
            Proyecto::factory()->create([
                'unidad_negocio_id' => 2,
                'grupo_proyecto_id' => 2,
                'nombre' => $nombre,
                'slug' => Str::slug($nombre),
            ]);
        }

        $nombres_3 = [
            'EL OLIVAR',
            'ENTRE BOSQUES',
            'FINCA LAS LOMAS ',
            'FUNDO MONASTERIO',
            'V. PLANICIE DE HUARAL',
            'PRADERAS DE HUARAL',
            'RINCONADA DEL LAGO',
            'VILLA PALERMO',
        ];

        foreach ($nombres_3 as $nombre) {
            Proyecto::factory()->create([
                'unidad_negocio_id' => 3,
                'grupo_proyecto_id' => 3,
                'nombre' => $nombre,
                'slug' => Str::slug($nombre),
            ]);
        }
    }
}
