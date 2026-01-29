<?php

namespace App\Exports;

use App\Models\EnvioCavali;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CavaliAceptanteExport implements FromCollection, WithHeadings
{
    public function __construct(private EnvioCavali $envio)
    {
    }

    public function title(): string
    {
        return 'ACEPTANTE';
    }

    public function collection()
    {
        return $this->envio->solicitudes->map(function ($s) {

            $cliente = $s->userCliente;
            $persona = $cliente->cliente;
            $direccion = $cliente->direcciones()->first();

            return [
                'codigo_venta' => $s->codigo_venta,
                'tipo_documento_aceptante' => 'DNI',
                'numero_documento_aceptante' => $persona->dni,
                'nombres_aceptante' => $persona->nombre,
                'apellidos_aceptante' => $persona->nombre, // (si luego separas, mejor)
                'domicilio_aceptante' => $direccion?->direccion,
                'localidad_aceptante' => $direccion?->distrito?->nombre,
                'correo_electronico_aceptante' => $cliente->email,
                'telefono_casa_aceptante' => '',
                'celular_aceptante' => $persona->telefono_principal,
                'tipo_firmante_aceptante' => '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'codigo_venta',
            'tipo_documento_aceptante',
            'numero_documento_aceptante',
            'nombres_aceptante',
            'apellidos_aceptante',
            'domicilio_aceptante',
            'localidad_aceptante',
            'correo_electronico_aceptante',
            'telefono_casa_aceptante',
            'celular_aceptante',
            'tipo_firmante_aceptante',
        ];
    }
}
