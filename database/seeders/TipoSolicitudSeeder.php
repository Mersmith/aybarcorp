<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoSolicitud;

class TipoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nombres_1 = [
            'SOLICITUD DE LETRAS',
            'CONSTANCIA DE NO ADEUDO',
            'CERTIFICADO DE LOTE',
            'ACTUALIZACION DE DATOS',
            'DEVOLUCION DE PAGO EXTRA',
            'SOLICITUD DE INFORMACION',
            'PROGRAMACION DE VISITA AL PROYECTO',
            'AVANCE DE PROYECTO',
            'DESISTIMIENTOS',
            'BOLETAS Y/O TICKETS DE PAGO',
            'PAGOS',
            'EE.CC',
            'CONTRATO PREPARATORIO',
            'FORMALIZACION',
            'LETRAS',
            'REQUERIMIENTO DE EXPEDIENTES (CONTRATO Y BOLETAS)',
            'DIGITACION',
        ];

        foreach ($nombres_1 as $nombre) {
            TipoSolicitud::factory()->create([
                'nombre' => $nombre,
                'tiempo_solucion' => 72,
            ]);
        }
    }
}
