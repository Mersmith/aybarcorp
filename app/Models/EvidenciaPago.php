<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvidenciaPago extends Model
{
    /** @use HasFactory<\Database\Factories\EvidenciaPagoFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unidad_negocio_id',
        'proyecto_id',
        'path',
        'url',
        'extension',
        'numero_operacion',
        'banco',
        'monto',
        'fecha',
        'observacion',
        'estado_evidencia_pago_id',
        'cliente_id',
        'usuario_valida_id',
        'fecha_validacion',
        'codigo_cliente',
        'razon_social',
        'nombre_proyecto',
        'etapa',
        'manzana',
        'lote',
        'codigo_cuota',
        'numero_cuota',
    ];

    protected $casts = [
        'fecha_validacion' => 'datetime',
        'monto' => 'decimal:2',
    ];

    public function unidadNegocio()
    {
        return $this->belongsTo(UnidadNegocio::class);
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuarioValida()
    {
        return $this->belongsTo(User::class, 'usuario_valida_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoEvidenciaPago::class, 'estado_evidencia_pago_id');
    }
}
