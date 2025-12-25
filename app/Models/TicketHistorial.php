<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketHistorial extends Model
{
    /** @use HasFactory<\Database\Factories\TicketHistorialFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'accion',
        'detalle',
    ];
}
