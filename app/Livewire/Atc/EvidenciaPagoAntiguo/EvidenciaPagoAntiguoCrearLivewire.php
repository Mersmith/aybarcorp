<?php

namespace App\Livewire\Atc\EvidenciaPagoAntiguo;

use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use App\Models\EstadoEvidenciaPago;
use Livewire\Attributes\Layout;
use App\Models\EvidenciaPagoAntiguo;
use App\Models\User;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoAntiguoCrearLivewire extends Component
{
    public function render()
    {
        return view('livewire.atc.evidencia-pago-antiguo.evidencia-pago-antiguo-crear-livewire');
    }
}
