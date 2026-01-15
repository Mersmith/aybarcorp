<?php

namespace App\Livewire\Cliente\CronogramaEstadoCuenta;

use App\Models\EstadoEvidenciaPago;
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
        $rechazadoId = EstadoEvidenciaPago::id(EstadoEvidenciaPago::RECHAZADO);

        $this->comprobantes = SolicitudEvidenciaPago::query()
            ->whereIn('codigo_cuota', collect($this->detalle)->pluck('idCuota'))
            ->withCount([
                'evidencias',
                'evidencias as evidencias_rechazadas_count' => function ($q) use ($rechazadoId) {
                    $q->where('estado_evidencia_pago_id', $rechazadoId);
                },
            ])
            ->get()
            ->keyBy('codigo_cuota');

        $this->detalle = collect($this->detalle)->map(function ($cuota) {
            $solicitud = $this->comprobantes->get($cuota['idCuota']);

            $total = $solicitud?->evidencias_count ?? 0;
            $rechazadas = $solicitud?->evidencias_rechazadas_count ?? 0;

            $validas = $total - $rechazadas;

            $cuota['comprobantes_count'] = $total;
            $cuota['comprobantes_rechazados_count'] = $rechazadas;

            $estaAprobada = $solicitud?->esta_aprobada ?? false;

            $cuota['puede_subir'] =
            !$estaAprobada
                && ($validas < 2);

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
