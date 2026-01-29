<?php

namespace App\Exports;

use App\Models\EnvioCavali;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CavaliGiradorExport implements FromCollection, WithHeadings
{
    public function __construct(private EnvioCavali $envio)
    {
    }

    public function title(): string
    {
        return 'GIRADOR';
    }

    public function collection()
    {
        return $this->envio->solicitudes
            ->unique('unidad_negocio_id') // 👈 importante
            ->map(function ($s) {

                $u = $s->unidadNegocio;

                return [
                    'ruc_girador' => $u->ruc,
                    'tipo_documento_rep_legal' => $u->cavali_girador_tipo_documento,
                    'documento_rep' => $u->cavali_girador_documento,
                    'nombre_rep_legal' => $u->cavali_girador_nombre,
                    'apellido_rep_legal' => $u->cavali_girador_apellido,
                    'email_rep_legal' => $u->cavali_girador_email,
                    'telefono_rep_legal' => $u->cavali_girador_telefono,
                ];
            });
    }

    public function headings(): array
    {
        return array_keys($this->collection()->first());
    }
}
