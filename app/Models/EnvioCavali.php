<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnvioCavali extends Model
{
    protected $table = 'envios_cavali';

    protected $fillable = [
        'fecha_corte',
        'unidad_negocio_id',
        'estado',
        'enviado_at',
        'archivo_zip',
    ];

    protected $casts = [
        'fecha_corte' => 'date',
        'enviado_at'  => 'datetime',
    ];

    public function solicitudes()
    {
        return $this->belongsToMany(
            SolicitudDigitalizarLetra::class,
            'envio_cavali_solicitud',
            'envios_cavali_id',
            'solicitud_digitalizar_letras_id'
        );
    }
}
