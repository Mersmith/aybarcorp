<?php

namespace App\Livewire\Backoffice\EvidenciaPago;

use App\Models\SolicitudEvidenciaPago;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoReporteDinamicoLivewire extends Component
{
    public $unidadesNegocio = [];
    public $proyectos = [];

    public $mesSeleccionado;
    public $unidadNegocioId = null;
    public $proyectoId = null;
    public $solicitudesPorFecha = [];

    public $solicitudesPorUnidad = [];


    public function mount()
    {
        $this->unidadesNegocio = UnidadNegocio::orderBy('nombre')->get();
        $this->proyectos = collect();

        $this->mesSeleccionado = now()->format('Y-m');
        $this->cargarPorFecha();

        $this->cargarPorUnidad();
    }

    public function updatedUnidadNegocioId()
    {
        $this->proyectoId = null;

        $this->proyectos = Proyecto::where('unidad_negocio_id', $this->unidadNegocioId)
            ->orderBy('nombre')
            ->get();

        $this->actualizarGrafico();
    }

    public function updatedProyectoId()
    {
        $this->actualizarGrafico();
    }

    public function updatedMesSeleccionado()
    {
        $this->actualizarGrafico();
    }

    private function actualizarGrafico()
    {
        $this->cargarPorFecha();
        $this->cargarPorUnidad();

        $this->dispatch('actualizarGraficoDiaMes', $this->solicitudesPorFecha);
        $this->dispatch('actualizarGraficoPorUnidad', $this->solicitudesPorUnidad);
    }

    private function cargarPorUnidad()
    {
        if (
            empty($this->mesSeleccionado) ||
            !preg_match('/^\d{4}-\d{2}$/', $this->mesSeleccionado)
        ) {
            $this->solicitudesPorUnidad = [
                'labels' => [],
                'data'   => [],
            ];
            return;
        }

        [$anio, $mes] = explode('-', $this->mesSeleccionado);

        $query = SolicitudEvidenciaPago::select(
            'unidad_negocio_id',
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', (int) $anio)
            ->whereMonth('created_at', (int) $mes);

        if ($this->unidadNegocioId) {
            $query->where('unidad_negocio_id', $this->unidadNegocioId);
        }

        if ($this->proyectoId) {
            $query->where('proyecto_id', $this->proyectoId);
        }

        $data = $query
            ->groupBy('unidad_negocio_id')
            ->with('unidadNegocio:id,nombre')
            ->get();

        $this->solicitudesPorUnidad = [
            'labels' => $data->map(
                fn($d) => $d->unidadNegocio?->nombre ?? 'Desconocido'
            )->values(),
            'data' => $data->pluck('total')->values(),
        ];
    }

    private function cargarPorFecha()
    {
        if (
            empty($this->mesSeleccionado) ||
            !preg_match('/^\d{4}-\d{2}$/', $this->mesSeleccionado)
        ) {
            $this->solicitudesPorFecha = [
                'labels' => [],
                'data'   => [],
            ];

            return;
        }

        [$anio, $mes] = explode('-', $this->mesSeleccionado);

        $query = SolicitudEvidenciaPago::select(
            DB::raw('DATE(created_at) as fecha'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes);

        if ($this->unidadNegocioId) {
            $query->where('unidad_negocio_id', $this->unidadNegocioId);
        }

        if ($this->proyectoId) {
            $query->where('proyecto_id', $this->proyectoId);
        }

        $data = $query
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('fecha')
            ->get();

        $this->solicitudesPorFecha = [
            'labels' => $data->pluck('fecha')->map(fn($f) => date('d', strtotime($f))),
            'data'   => $data->pluck('total'),
        ];
    }

    public function render()
    {
        return view('livewire.backoffice.evidencia-pago.evidencia-pago-reporte-dinamico-livewire');
    }
}
