<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagen extends Model
{
    /** @use HasFactory<\Database\Factories\ImagenFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'path',
        'url',
        'titulo',
        'descripcion',
        'extension',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

}
