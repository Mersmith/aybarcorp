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
        'cliente_id',

        'path',
        'url',
        'extension',
        'numero_operacion',
        'banco',
        'monto',
        'fecha',
        'observacion',
        'estado_evidencia_pago_id',
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
        'transaccion_id',
        'slin_monto',
        'lote_completo',

        'gestor_id',

        'slin_asbanc',
        'slin_evidencia',

        // valida
        'usuario_valida_id',
        'fecha_validacion',

        // auditoría
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'fecha_validacion' => 'datetime',
        'monto' => 'decimal:2',
        'slin_monto' => 'decimal:2',
    ];

    public function unidadNegocio()
    {
        return $this->belongsTo(UnidadNegocio::class);
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function userCliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoEvidenciaPago::class, 'estado_evidencia_pago_id');
    }

    public function gestor()
    {
        return $this->belongsTo(User::class, 'gestor_id');
    }

    // valida
    public function usuarioValida()
    {
        return $this->belongsTo(User::class, 'usuario_valida_id');
    }

    // auditoria
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function eliminador()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    protected static function booted()
    {
        static::creating(function ($ticket) {
            if (auth()->check()) {
                $ticket->created_by = auth()->id();
            }
        });

        static::updating(function ($ticket) {
            if (auth()->check()) {
                $ticket->updated_by = auth()->id();
            }
        });

        static::deleting(function ($ticket) {
            if (auth()->check()) {
                $ticket->deleted_by = auth()->id();
                $ticket->saveQuietly();
            }
        });
    }
}
