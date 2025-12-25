<?php

namespace App\Livewire\Atc\ReporteCita;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Cita;
use App\Models\Sede;
use App\Models\MotivoCita;
use App\Models\EstadoCita;
use App\Models\User;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.admin.layout-admin')]
class ReporteCitaLivewire extends Component
{
    public $porEstado = [];
    public $porSede = [];
    public $porMotivo = [];
    public $porFecha = [];
    public $rankingUsuarios = [];

    public function mount()
    {
        $this->loadPorEstado();
        $this->loadPorSede();
        $this->loadPorMotivo();
        $this->loadPorFecha();
        $this->loadRankingUsuarios();
    }

    private function loadPorEstado()
    {
        $data = Cita::select('estado_cita_id', DB::raw('count(*) as total'))
            ->groupBy('estado_cita_id')->get();

        $this->porEstado = [
            'labels' => $data->map(fn($i) => EstadoCita::find($i->estado_cita_id)?->nombre ?? "N/A"),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadPorSede()
    {
        $data = Cita::select('sede_id', DB::raw('count(*) as total'))
            ->groupBy('sede_id')->get();

        $this->porSede = [
            'labels' => $data->map(fn($i) => Sede::find($i->sede_id)?->nombre ?? "Sin sede"),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadPorMotivo()
    {
        $data = Cita::select('motivo_cita_id', DB::raw('count(*) as total'))
            ->groupBy('motivo_cita_id')->get();

        $this->porMotivo = [
            'labels' => $data->map(fn($i) => MotivoCita::find($i->motivo_cita_id)?->nombre ?? "Otros"),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadPorFecha()
    {
        $data = Cita::select(DB::raw('DATE(created_at) as fecha'), DB::raw('count(*) as total'))
            ->groupBy('fecha')->orderBy('fecha')->take(15)->get();

        $this->porFecha = [
            'labels' => $data->pluck('fecha'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadRankingUsuarios()
    {
        $data = Cita::select('usuario_cierra_id', DB::raw('count(*) as total'))
            ->whereNotNull('usuario_cierra_id')
            ->groupBy('usuario_cierra_id')
            ->orderByDesc('total')
            ->take(5)->get();

        $this->rankingUsuarios = [
            'labels' => $data->map(fn($i) => User::find($i->usuario_cierra_id)?->name ?? "Usuario"),
            'data'   => $data->pluck('total'),
        ];
    }

    public function render()
    {
        return view('livewire.atc.reporte-cita.reporte-cita-livewire');
    }
}
