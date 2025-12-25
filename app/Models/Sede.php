<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sede extends Model
{
    /** @use HasFactory<\Database\Factories\SedeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'direccion',
        'activo',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
