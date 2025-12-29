<?php

namespace App\Livewire\Cliente\EstadoCuenta;

use Livewire\Component;

class EstadoCuentaVerLivewire extends Component
{
    public $lote;
    public $estado_cuenta = [];

    public function mount($lote, $estado_cuenta)
    {
        $this->lote = $lote;

        $this->estado_cuenta = $estado_cuenta;
    }

    public function render()
    {
        return view('livewire.cliente.estado-cuenta.estado-cuenta-ver-livewire');
    }
}
