<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archivo extends Model
{
    /** @use HasFactory<\Database\Factories\ArchivoFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'archivable_id',
        'archivable_type',
        'path',
        'url',
        'titulo',
        'descripcion',
        'extension'
    ];

    public function archivable()
    {
        return $this->morphTo();
    }
}
