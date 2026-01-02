<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\EvidenciaPagoAntiguo;

class EvidenciaPagoAntiguoImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Evita filas vacías
            if (empty($row['imagen_url'])) {
                continue;
            }

            EvidenciaPagoAntiguo::create([
                'id'           => $row['id'],
                'imagen_url'           => $row['imagen_url'],
                'fecha_deposito'       => $this->parseFecha($row['fecha_deposito'] ?? null),
                'union'                => $row['union'] ?? null,
                'codigo_cliente'       => $row['codigo_cliente'] ?? null,
                'proyecto_id'             => $row['proyecto_id'] ?? null,
                'proyecto_nombre'             => $row['proyecto'] ?? null,
                'etapa'                => $row['etapa'] ?? null,
                'lote'                 => $row['lote'] ?? null,
                'nombres_cliente'              => $row['cliente'] ?? null,
                'cuota_fija'           => $row['cuota_fija'] ?? null,
                'monto'                => $row['monto'] ?? null,
                'operacion_numero'     => $row['operacion_numero'] ?? null,
                'operacion_hora'       => $row['operacion_hora'] ?? null,
                'pago_de'              => $row['pago_de'] ?? null,
                'codigo_cuenta'        => $row['codigo_cuenta'] ?? null,
                'nombre_archivo'       => $row['nombre_archivo'] ?? null,
                'numero_cuota'              => $row['numero_cuota'] ?? null,
                'moneda'               => $row['moneda'] ?? null,
                'unidad_negocio_id'         => $row['unidad_negocio_id'] ?? null,
                'razon_social'         => $row['razon_social'] ?? null,
                'medio_pago'           => $row['medio_pago'] ?? null,
                'estado_evidencia_pago_id'      => $row['estado_evidencia_pago_id'] ?? null,
                'estado_registro'      => $row['estado_registro'] ?? null,
                'gestor_id'      => $row['gestor_id'] ?? null,
                'gestor'      => $row['gestor'] ?? null,
                'fecha_registro'  => $this->parseFecha($row['fecha_registro'] ?? null),
                'observacion'          => $row['observacion'] ?? null,
                'usuario_valida_id'  => $row['usuario_valida_id'] ?? null,
                'validador' => $row['validador'] ?? null,
                'fecha_validacion'  => $this->parseFecha($row['fecha_validacion'] ?? null),
            ]);
        }
    }

    private function parseFecha($value)
    {
        if (!$value) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value);
        } catch (\Throwable) {
            return null;
        }
    }
}
