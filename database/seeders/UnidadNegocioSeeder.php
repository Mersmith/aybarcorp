<?php

namespace Database\Seeders;

use App\Models\UnidadNegocio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadNegocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = [
            [
                'nombre' => 'AYBAR CORP. S.A.C',
                'razon_social' => 'AYBAR CORP. S.A.C',
            ],
            [
                'nombre' => 'PONTEVEDRA S.A.C',
                'razon_social' => 'PONTEVEDRA S.A.C',
            ],
            [
                'nombre' => 'VIVANORTE S.A.C',
                'razon_social' => 'VIVANORTE S.A.C',
            ],
            //nuevo
            [
                'nombre' => 'AYBAR INVESTMENTS S.A.C',
                'razon_social' => 'AYBAR INVESTMENTS S.A.C',
            ],
            [
                'nombre' => 'GROCIO PRADO',
                'razon_social' => 'GROCIO PRADO',
            ],
            [
                'nombre' => 'LOTES DEL PERU S.A.C',
                'razon_social' => 'LOTES DEL PERU S.A.C',
            ],
        ];

        UnidadNegocio::insert($unidades);
    }
}
