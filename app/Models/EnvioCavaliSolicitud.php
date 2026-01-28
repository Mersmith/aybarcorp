<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EnvioCavaliSolicitud extends Pivot
{
    protected $table = 'envio_cavali_solicitud';
}
