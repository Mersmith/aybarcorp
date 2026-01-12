<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    /** @use HasFactory<\Database\Factories\AreaFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'email_buzon',
        'color',
        'icono',
        'activo',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_principal')
            ->withTimestamps();
    }

    public function tipos()
    {
        return $this->belongsToMany(TipoSolicitud::class, 'area_tipo_solicitud');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }


    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function principal()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_principal')
            ->wherePivot('is_principal', true);
    }
}
