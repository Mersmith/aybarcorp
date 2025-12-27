<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unidad_negocio_id',
        'proyecto_id',
        'cliente_id',

        'area_id',
        'tipo_solicitud_id',
        'sub_tipo_solicitud_id',
        'canal_id',
        'estado_ticket_id',
        'prioridad_ticket_id',
        'usuario_asignado_id',
        'asunto_inicial',
        'descripcion_inicial',
        'lotes',
        'asunto',
        'descripcion',
        'dni',
        'nombres',
        'origen',

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
        'lotes' => 'array',
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
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function tipoSolicitud()
    {
        return $this->belongsTo(TipoSolicitud::class, 'tipo_solicitud_id');
    }

    public function subTipoSolicitud()
    {
        return $this->belongsTo(SubTipoSolicitud::class, 'sub_tipo_solicitud_id');
    }

    public function canal()
    {
        return $this->belongsTo(Canal::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoTicket::class, 'estado_ticket_id');
    }

    public function prioridad()
    {
        return $this->belongsTo(PrioridadTicket::class, 'prioridad_ticket_id');
    }

    public function asignado()
    {
        return $this->belongsTo(User::class, 'usuario_asignado_id');
    }

    public function historial()
    {
        return $this->hasMany(TicketHistorial::class);
    }

    public function derivados()
    {
        return $this->hasMany(TicketDerivado::class);
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }

    public function getTieneDerivadosAttribute()
    {
        return $this->derivados()->exists();
    }

    public function getTieneArchivosAttribute()
    {
        return $this->archivos()->exists();
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
