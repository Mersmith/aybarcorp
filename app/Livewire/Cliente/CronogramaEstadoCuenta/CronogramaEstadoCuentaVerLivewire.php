<?php

namespace App\Livewire\Cliente\CronogramaEstadoCuenta;

use App\Models\SolicitudEvidenciaPago;
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
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => '¡No esta autorizado! Solo el cliente sube sus evidencias.']);
            return;
        }

        $this->cuota = $cuota;
    }

    #[On('actualizarCronograma')]
    public function loadComprobantesYActualizarCronograma()
    {
        $this->comprobantes = SolicitudEvidenciaPago::query()
            ->where('razon_social', $this->lote['razon_social'])
            ->where('nombre_proyecto', $this->lote['descripcion'])
            ->where('etapa', $this->lote['id_etapa'])
            ->where('manzana', $this->lote['id_manzana'])
            ->where('lote', $this->lote['id_lote'])
            ->withCount('evidencias')
            ->get()
            ->keyBy('codigo_cuota');

        $this->detalle = collect($this->detalle)->map(function ($cuota) {
            $solicitud = $this->comprobantes->get($cuota['idCuota']);

            $cuota['comprobantes_count'] = $solicitud
            ? $solicitud->evidencias_count
            : 0;

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
