<?php

namespace App\Livewire\Atc\EvidenciaPago;

use App\Models\EstadoEvidenciaPago;
use App\Models\EvidenciaPago;
use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoReporteLivewire extends Component
{
    public $evidenciasPorEstado = ['labels' => [], 'data' => []];
    public $evidenciasPorProyecto = ['labels' => [], 'data' => []];
    public $evidenciasPorFecha = ['labels' => [], 'data' => []];

    public function mount()
    {
        $this->loadEvidenciasPorEstado();
        $this->loadEvidenciasPorProyecto();
        $this->loadEvidenciasPorFecha();
    }

    private function loadEvidenciasPorEstado()
    {
        $data = EvidenciaPago::select(
            'estado_evidencia_pago_id',
            DB::raw('count(*) as total')
        )
            ->groupBy('estado_evidencia_pago_id')
            ->get();

        $this->evidenciasPorEstado = [
            'labels' => $data->map(fn($i) =>
                EstadoEvidenciaPago::find($i->estado_evidencia_pago_id)?->nombre ?? 'Desconocido'
            ),
            'data' => $data->pluck('total'),
        ];
    }

    private function loadEvidenciasPorProyecto()
    {
        $data = EvidenciaPago::select(
            'proyecto_id',
            DB::raw('count(*) as total')
        )
            ->groupBy('proyecto_id')
            ->orderByDesc('total')
            ->get();

        $this->evidenciasPorProyecto = [
            'labels' => $data->map(fn($i) =>
                Proyecto::find($i->proyecto_id)?->nombre ?? 'Sin proyecto'
            ),
            'data' => $data->pluck('total'),
        ];
    }

    private function loadEvidenciasPorFecha()
    {
        $data = EvidenciaPago::select(
            DB::raw('DATE(created_at) as fecha'),
            DB::raw('count(*) as total')
        )
        ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('fecha')
            ->take(30)
            ->get();

        $this->evidenciasPorFecha = [
            'labels' => $data->pluck('fecha'),
            'data' => $data->pluck('total'),
        ];
    }

    public function render()
    {
        return view('livewire.atc.evidencia-pago.evidencia-pago-reporte-livewire');
    }
}
