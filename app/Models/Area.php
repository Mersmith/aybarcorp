<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    /** @use HasFactory<\Database\Factories\AreaFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['nombre', 'activo'];

    public function usuarios()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

}
