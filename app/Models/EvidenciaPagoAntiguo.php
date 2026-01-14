<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaPagoAntiguo extends Model
{
    /** @use HasFactory<\Database\Factories\EvidenciaPagoAntiguoFactory> */
    use HasFactory;

    protected $table = 'evidencia_pago_antiguos';

    public $incrementing = false;   // ⬅️ CLAVE
    protected $keyType = 'int';

    protected $guarded = [];

    /*protected $fillable = [
        'unidad_negocio_id',
        'proyecto_id',
        'cliente_id',

        'imagen_url',

        'operacion_numero',
        'operacion_hora',
        'union',
        'cuota_fija',
        'monto',
        'pago_de',
        'codigo_cuenta',
        'nombre_archivo',
        'moneda',
        'medio_pago',
        'fecha_deposito',

        'observacion',
        'estado_evidencia_pago_id',
        'estado_registro',

        'codigo_cliente',
        'nombres_cliente',
        'razon_social',
        'proyecto',
        'etapa',
        'lote',
        'numero_cuota',

        'gestor',
        'gestor_id',
        'fecha_registro',

        // valida
        'usuario_valida_id',
        'validador',
        'fecha_validacion',

        // auditoría
        'created_by',
        'updated_by',
        'deleted_by',
    ];*/

    protected $casts = [
        'fecha_deposito'   => 'date',
        'fecha_registro'   => 'date',
        //'cuota_fija'       => 'decimal:2',
        'fecha_validacion' => 'date',
        //'monto'            => 'decimal:2',
    ];

    public function unidadNegocio()
    {
        return $this->belongsTo(UnidadNegocio::class, 'unidad_negocio_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function cliente()
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
