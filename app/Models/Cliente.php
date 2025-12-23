<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'cuc',
        'dni',
        'codigo_cliente',
        'nombre_completo',
        'telefono_principal',
        'telefono_alternativo',
        'imagen_ruta',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evidenciasPagos()
    {
        return $this->hasMany(EvidenciaPago::class, 'cliente_id');
    }
}
