<?php

namespace App\Exports;

use App\Models\EnvioCavali;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CavaliLetrasExport implements FromCollection, WithHeadings
{
    public function __construct(private EnvioCavali $envio)
    {
    }

    public function title(): string
    {
        return 'LETRAS';
    }

    public function collection()
    {
        return $this->envio->solicitudes->map(function ($s) {

            $unidad = $s->unidadNegocio;

            return [
                'codigo_venta' => $s->codigo_venta,
                'tipo_venta' => 'VENT',
                'ruc_cuenta_matriz' => $unidad->ruc,
                'ruc_titular' => $unidad->ruc,
                'tipo_documento_girador' => 'RUC',
                'numero_documento_girador' => $unidad->ruc,
                'razon_social_girador' => $unidad->razon_social,
                'numero_letra' => $s->codigo_venta,
                'referencia_girador' => '',
                'fecha_giro' => now()->format('Y-m-d'),
                'lugar_giro' => '',
                'fecha_vencimiento' => $s->fecha_vencimiento,
                'moneda' => 'S',
                'importe' => $s->importe_cuota,
                'lugar_pago' => '',
                'clausula_prorroga' => '',
                'plaza' => '',
                'nombre_proyecto' => $s->nombre_proyecto,
                'protesto' => '',
                'tipo_transferencia' => '',
            ];
        });
    }

    public function headings(): array
    {
        return array_keys($this->collection()->first());
    }
}
