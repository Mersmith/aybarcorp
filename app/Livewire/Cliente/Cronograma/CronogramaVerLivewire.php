<?php

namespace App\Livewire\Cliente\Cronograma;

use App\Models\EvidenciaPago;
use Livewire\Attributes\On;
use Livewire\Component;

class CronogramaVerLivewire extends Component
{
    public $lote;
    public $cronograma = [];
    public $cabecera = [];
    public $detalle = [];
    public $cuota = null;

    public $comprobantes;

    public int $total_pagados = 0;

    public function mount($lote, $cronograma)
    {
        $this->lote = $lote;

        $this->cronograma = $cronograma;
        $this->cabecera = $cronograma['datos_cabecera'];
        $this->detalle = $cronograma['detalle_cuotas'];

        /*$this->total_pagados = collect($this->cronograma)
            ->where('estado', 'PAGADO')
            ->count();*/

        $this->loadComprobantesYActualizarCronograma();
    }

    public function seleccionarCuota($cuota)
    {
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
                ->where('codigo_cuota', $cuota['codigo'])
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
        return view('livewire.cliente.cronograma.cronograma-ver-livewire');
    }
}
