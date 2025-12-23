<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoEvidenciaPago extends Model
{
    /** @use HasFactory<\Database\Factories\EstadoEvidenciaPagoFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'color',
        'icono',
        'activo',
    ];

    public function evidencias()
    {
        return $this->hasMany(EvidenciaPago::class);
    }
}
