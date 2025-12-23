<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaPagoAntiguo extends Model
{
    /** @use HasFactory<\Database\Factories\EvidenciaPagoAntiguoFactory> */
    use HasFactory;

    protected $table = 'evidencia_pago_antiguos';

    protected $fillable = [
        'imagen_url',
        'fecha_deposito',
        'union',
        'codigo_cliente',
        'proyecto',
        'etapa',
        'lote',
        'cliente',
        'cuota_fija',
        'monto',
        'operacion_numero',
        'operacion_hora',
        'pago_de',
        'codigo_cuenta',
        'nombre_archivo',
        'numero_cuota',
        'moneda',
        'razon_social',
        'medio_pago',

        'estado_registro',

        'gestor',
        'gestor_id',
        'fecha_registro',
        'observacion',

        'validador_id',
        'validador',
        'fecha_validacion',
    ];

    protected $casts = [
        'fecha_deposito'   => 'date',
        'fecha_registro'   => 'date',
        'fecha_validacion' => 'date',
        'monto'            => 'decimal:2',
        'cuota_fija'       => 'decimal:2',
    ];
}
