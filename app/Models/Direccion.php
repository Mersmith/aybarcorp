<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    /** @use HasFactory<\Database\Factories\DireccionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recibe_nombres',
        'recibe_celular',
        'departamento_id',
        'provincia_id',
        'distrito_id',
        'direccion',
        'direccion_numero',
        'opcional',
        'codigo_postal',
        'instrucciones',
        'es_principal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }
}
