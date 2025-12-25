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
    ];

    protected $casts = [
        'lotes' => 'array',
    ];

    const PRIORIDADES = [
        1 => 'Alta',
        2 => 'Media',
        3 => 'Baja',
    ];

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

    public function getPrioridadNombreAttribute()
    {
        return self::PRIORIDADES[$this->prioridad] ?? 'Desconocida';
    }

    public function getTieneDerivadosAttribute()
    {
        return $this->derivados()->exists();
    }
}
