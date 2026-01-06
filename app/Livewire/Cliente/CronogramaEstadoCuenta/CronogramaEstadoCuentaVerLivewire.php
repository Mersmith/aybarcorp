<?php

namespace App\Livewire\Cliente\CronogramaEstadoCuenta;

use App\Models\EvidenciaPago;
use Livewire\Attributes\On;
use Livewire\Component;

class CronogramaEstadoCuentaVerLivewire extends Component
{
    public $lote;
    public $estado_cuenta = [];

    public $detalle = [];
    public $cuota = null;

    public $comprobantes;

    public function mount($lote, $estado_cuenta)
    {
        $this->lote = $lote;

        $this->estado_cuenta = $estado_cuenta;
        $this->detalle = $estado_cuenta['Cuotas'];

        $this->loadComprobantesYActualizarCronograma();
    }

    public function seleccionarCuota($cuota)
    {
        if (auth()->user()->rol !== 'cliente') {
            abort(403, 'No autorizado.');
        }

        $this->cuota = $cuota;
    }

    #[On('actualizarCronograma')]
    public function loadComprobantesYActualizarCronograma()
    {
        $this->comprobantes = EvidenciaPago::where('razon_social', $this->lote['razon_social'])
            ->where('nombre_proyecto', $this->lote['descripcion'])
            ->where('manzana', $this->lote['id_manzana'])
            ->where('lote', $this->lote['id_lote'])
            ->get();

        $this->detalle = collect($this->detalle)->map(function ($cuota) {
            $cuota['comprobantes_count'] = $this->comprobantes
                ->where('codigo_cuota', $cuota['idCuota'])
                ->count();
            return $cuota;
        });
    }

    #[On('cerrarModalEvidenciaPagoOn')]
    public function cerrarModalEvidenciaPago()
    {
        $this->cuota = null;
    }

    public function render()
    {
        return view('livewire.cliente.cronograma-estado-cuenta.cronograma-estado-cuenta-ver-livewire');
    }
}
