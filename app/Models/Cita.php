<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    /** @use HasFactory<\Database\Factories\CitaFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'usuario_solicita_id',
        'usuario_recibe_id',
        'usuario_cierra_id',
        'sede_id',
        'motivo_cita_id',
        'estado_cita_id',
        'fecha_inicio',
        'fecha_fin',
        'fecha_cierre',
        'asunto_solicitud',
        'descripcion_solicitud',
        'asunto_respuesta',
        'descripcion_respuesta',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin'   => 'datetime',
        'fecha_cierre'   => 'datetime',
    ];

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'usuario_solicita_id');
    }

    public function receptor()
    {
        return $this->belongsTo(User::class, 'usuario_recibe_id');
    }

    public function cierrePor()
    {
        return $this->belongsTo(User::class, 'usuario_cierra_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function motivo()
    {
        return $this->belongsTo(MotivoCita::class, 'motivo_cita_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoCita::class, 'estado_cita_id');
    }
}
