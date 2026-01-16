<?php

namespace App\Livewire\Atc\EvidenciaPagoAntiguo;

use App\Models\EvidenciaPagoAntiguo;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoAntiguoReporteLivewire extends Component
{
    public $totalEvidencias;
    public $evidenciasSinAsignar;
    public $evidenciasAsignadas;

    public $evidenciasPorEstado = [];
    public $evidenciasPorProyecto = [];
    public $evidenciasPorFecha = [];
    public $evidenciasValidadas = [];
    public $solicitudesPorUnidad = [];
    public $topGestores = [];


    public function mount()
    {
        $this->cargarTotales();
        $this->cargarPorEstado();
        $this->cargarValidadas();
        $this->cargarPorProyecto();
        $this->cargarPorFecha();
        $this->cargarPorUnidad();
        $this->cargarTopGestores();
    }

    private function cargarTotales()
    {
        $this->totalEvidencias = EvidenciaPagoAntiguo::count();
        $this->evidenciasSinAsignar = EvidenciaPagoAntiguo::whereNull('gestor_id')->count();
        $this->evidenciasAsignadas = $this->totalEvidencias - $this->evidenciasSinAsignar;
    }

    private function cargarPorEstado()
    {
        $data = EvidenciaPagoAntiguo::query()
            ->leftJoin(
                'estado_evidencia_pagos',
                'estado_evidencia_pagos.id',
                '=',
                'evidencia_pago_antiguos.estado_evidencia_pago_id'
            )
            ->select(
                DB::raw('COALESCE(estado_evidencia_pagos.nombre, "Desconocido") as estado'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('estado')
            ->get();

        $this->evidenciasPorEstado = [
            'labels' => $data->pluck('estado'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function cargarValidadas()
    {
        $validadas = EvidenciaPagoAntiguo::whereNotNull('fecha_validacion')->count();
        $pendientes = $this->totalEvidencias - $validadas;

        $this->evidenciasValidadas = [
            'labels' => ['Validadas', 'Pendientes'],
            'data' => [$validadas, $pendientes],
        ];
    }

    private function cargarPorUnidad()
    {
        $data = EvidenciaPagoAntiguo::query()
            ->leftJoin(
                'unidad_negocios',
                'unidad_negocios.id',
                '=',
                'evidencia_pago_antiguos.unidad_negocio_id'
            )
            ->select(
                DB::raw('COALESCE(unidad_negocios.nombre, "Sin unidad") as unidad'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('unidad')
            ->orderByDesc('total')
            ->get();

        $this->solicitudesPorUnidad = [
            'labels' => $data->pluck('unidad'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function cargarPorProyecto()
    {
        $data = EvidenciaPagoAntiguo::query()
            ->leftJoin(
                'proyectos',
                'proyectos.id',
                '=',
                'evidencia_pago_antiguos.proyecto_id'
            )
            ->select(
                DB::raw('COALESCE(proyectos.nombre, "Sin proyecto") as proyecto'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('proyecto')
            ->orderByDesc('total')
            ->get();

        $this->evidenciasPorProyecto = [
            'labels' => $data->pluck('proyecto'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function cargarPorFecha()
    {
        $data = EvidenciaPagoAntiguo::query()
            ->select(
                DB::raw('DATE(fecha_registro) as fecha'),
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('fecha_registro')
            ->groupBy(DB::raw('DATE(fecha_registro)'))
            ->orderBy('fecha')
            ->take(30)
            ->get();

        $this->evidenciasPorFecha = [
            'labels' => $data->pluck('fecha'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function cargarTopGestores()
    {
        $data = EvidenciaPagoAntiguo::query()
            ->leftJoin('users', 'users.id', '=', 'evidencia_pago_antiguos.gestor_id')
            ->select(
                DB::raw('COALESCE(users.name, evidencia_pago_antiguos.gestor, "Desconocido") as gestor'),
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('fecha_validacion')
            ->groupBy(
                'users.name',
                'evidencia_pago_antiguos.gestor'
            )
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $this->topGestores = [
            'labels' => $data->pluck('gestor'),
            'data'   => $data->pluck('total'),
        ];
    }

    public function render()
    {
        return view('livewire.atc.evidencia-pago-antiguo.evidencia-pago-antiguo-reporte-livewire');
    }
}
