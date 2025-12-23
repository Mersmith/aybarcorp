<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagen extends Model
{
    /** @use HasFactory<\Database\Factories\ImagenFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['path', 'url', 'titulo', 'descripcion', 'extension'];

}
