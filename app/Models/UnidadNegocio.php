<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadNegocio extends Model
{
    /** @use HasFactory<\Database\Factories\UnidadNegocioFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre', 
        'razon_social',
        'ruc',
        'slin_id',

        //REPRESENTANTE LEGAL DEL GIRADOR
        'cavali_girador_tipo_documento',
        'cavali_girador_documento',
        'cavali_girador_nombre',
        'cavali_girador_apellido',
        'cavali_girador_email',
        'cavali_girador_telefono',
    ];

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

    public function evidencias()
    {
        return $this->hasMany(EvidenciaPago::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
