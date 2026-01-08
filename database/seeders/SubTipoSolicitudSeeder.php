<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubTipoSolicitud;

class SubTipoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $nombres_1 = [
            ['tipo_solicitud_id' => 1, 'nombre' => 'SOLICITUD DE LETRAS'],
            ['tipo_solicitud_id' => 1, 'nombre' => 'STATUS DE SOLICITUD DE LETRAS'],
            ['tipo_solicitud_id' => 2, 'nombre' => 'SOLICITUD DE CONSTANCIA DE NO ADEUDO'],
            ['tipo_solicitud_id' => 2, 'nombre' => 'STATUS DE SOLICITUD DE CONSTANCIA DE NO ADEUDO'],
            ['tipo_solicitud_id' => 3, 'nombre' => 'SOLICITUD DE CERTIFICADO DE LOTE'],
            ['tipo_solicitud_id' => 3, 'nombre' => 'STATUS DE SOLICITUD DE CERTIFICADO DE LOTE'],
            ['tipo_solicitud_id' => 4, 'nombre' => 'ACTUALIZACION DE DATOS'],
            ['tipo_solicitud_id' => 4, 'nombre' => 'STATUS DE ACTUALIZACION DE DATOS'],
            ['tipo_solicitud_id' => 5, 'nombre' => 'DEVOLUCION DE PAGO EXTRA'],
            ['tipo_solicitud_id' => 5, 'nombre' => 'STATUS DE DEVOLUCION DE PAGO EXTRA'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'HABILITACION URBANA'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'CONSTANCIA DE NO ADEUDO'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'CERTIFICADO DE LOTE'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'DEVOLUCION DE PAGO EXTRA 2'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'PROGRAMACION DE VISITA AL PROYECTO'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'DESISTIMIENTO'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'EE.CC'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'CITA CON ASESOR LEGAL'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'CESION DE POSICION CONTRACTUAL'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'TRASPASO DE APORTES'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'COPIA LEGALIZADA DE CONTRATO'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'LEGALIZACION DE FIRMAS'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'FORMALIZACION DE CONTRATO DEFINITIVO'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'MODIFICACION DE CONTRATO DEFINITIVO / MINUTA'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'AVANCE DE PROYECTO'],
            ['tipo_solicitud_id' => 6, 'nombre' => 'REUBICACIONES'],
            ['tipo_solicitud_id' => 7, 'nombre' => 'PROGRAMACION DE VISITA AL PROYECTO 2'],
            ['tipo_solicitud_id' => 7, 'nombre' => 'STATUS DE PROGRAMACION DE VISITA AL PROYECTO'],
            ['tipo_solicitud_id' => 8, 'nombre' => 'INFORMACION SOBRE AVANCE DE PROYECTO '],
            ['tipo_solicitud_id' => 8, 'nombre' => 'STATUS DE INFORMACION SOBRE AVANCE DE PROYECTO'],
            ['tipo_solicitud_id' => 9, 'nombre' => 'SOLICITUD DE DESISTIMIENTO'],
            ['tipo_solicitud_id' => 9, 'nombre' => 'STATUS DE SOLICITUD DE DESISTIMIENTOS'],
            ['tipo_solicitud_id' => 10, 'nombre' => 'ENVIO DE BOLETAS O TICKETS DE PAGO'],
            ['tipo_solicitud_id' => 10, 'nombre' => 'STATUS DE ENVIO DE BOLETAS O TICKETS DE PAGO'],
            ['tipo_solicitud_id' => 10, 'nombre' => 'CORRECCION DE BOLETAS O TICKETS DE PAGO'],
            ['tipo_solicitud_id' => 10, 'nombre' => 'STATUS DE CORRECCION DE BOLETAS O TICKETS DE PAGO'],
            ['tipo_solicitud_id' => 11, 'nombre' => 'REGULARIZACION DE PAGOS'],
            ['tipo_solicitud_id' => 11, 'nombre' => 'STATUS DE REGULARIZACION DE PAGOS'],
            ['tipo_solicitud_id' => 11, 'nombre' => 'EXONERACION DE PENALIDADES'],
            ['tipo_solicitud_id' => 11, 'nombre' => 'STATUS DE EXONERACION DE PENALIDADEA'],
            ['tipo_solicitud_id' => 11, 'nombre' => 'ACTUALIZACION DE PAGOS EN SISTEMA'],
            ['tipo_solicitud_id' => 11, 'nombre' => 'STATUS DE ACTUALIZACION DE PAGOS EN SISTEMA'],
            ['tipo_solicitud_id' => 11, 'nombre' => 'FORMAS DE PAGO'],
            ['tipo_solicitud_id' => 11, 'nombre' => 'INCIDENCIA PARA REALIZAR PAGOS'],
            ['tipo_solicitud_id' => 12, 'nombre' => 'SOLICITUD DE EE.CC'],
            ['tipo_solicitud_id' => 12, 'nombre' => 'STATUS DE SOLICITUD DE EE.CC'],
            ['tipo_solicitud_id' => 13, 'nombre' => 'CESION DE POSICION CONTRACTUAL 2'],
            ['tipo_solicitud_id' => 13, 'nombre' => 'TRASPASO DE APORTES 2'],
            ['tipo_solicitud_id' => 13, 'nombre' => 'DESISTIMIENTO 2s'],
            ['tipo_solicitud_id' => 13, 'nombre' => 'MODIFICACIÓN DE CONTRATO PREPARATORIO'],
            ['tipo_solicitud_id' => 13, 'nombre' => 'ESTADO DE RESPUESTA DE CARTA NOTARIAL'],
            ['tipo_solicitud_id' => 13, 'nombre' => 'REUBICACIONES 2'],
            ['tipo_solicitud_id' => 14, 'nombre' => 'FORMALIZACION DE CONTRATO DEFINITIVO 2'],
            ['tipo_solicitud_id' => 15, 'nombre' => 'DAR RESPUESTA A REQUERIMIENTOS DE LETRAS'],
            ['tipo_solicitud_id' => 15, 'nombre' => 'VALIDACION DE LETRAS'],
            ['tipo_solicitud_id' => 15, 'nombre' => 'INVENTARIO DE LETRAS'],
            ['tipo_solicitud_id' => 16, 'nombre' => 'DIGITALIZACION DE EXPEDIENTES'],
            ['tipo_solicitud_id' => 17, 'nombre' => 'ATENDER SOLICITUDES'],
            ['tipo_solicitud_id' => 17, 'nombre' => 'DIGITALIZACION Y CARGA DE INFORMACION'],
        ];

        foreach ($nombres_1 as $nombre) {
            SubTipoSolicitud::factory()->create($nombre);
        }

    }
}
