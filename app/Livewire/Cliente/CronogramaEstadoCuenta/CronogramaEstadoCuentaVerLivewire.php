<?php

namespace App\Livewire\Cliente\CronogramaEstadoCuenta;

use Livewire\Component;

class CronogramaEstadoCuentaVerLivewire extends Component
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
        return view('livewire.cliente.cronograma-estado-cuenta.cronograma-estado-cuenta-ver-livewire');
    }
}
