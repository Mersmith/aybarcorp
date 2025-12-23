<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoProyecto extends Model
{
    /** @use HasFactory<\Database\Factories\GrupoProyectoFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'slug',
        'titulo',
        'subtitulo',
        'imagen',
        'activo',
        'meta_title',
        'meta_description',
        'meta_image',
        'views'
    ];

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }
}
