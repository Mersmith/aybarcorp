<?php

namespace App\Livewire\Atc\Reporte;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Area;
use App\Models\EstadoTicket;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin.layout-admin')]
class ReporteLivewire extends Component
{
    public $ticketsPorEstado = [];
    public $ticketsPorArea = [];
    public $ticketsPorFecha = [];
    public $rankingUsuarios = [];
    public $ticketsPorCanal = [];
    public $ticketsPorTipo = [];
    public $derivacionesPorArea = [];
    public $derivacionesPorFecha = [];
    public $tiempoCierrePorDia = [];

    public function mount()
    {
        $this->loadTicketsEstado();
        $this->loadTicketsArea();
        $this->loadTicketsFecha();
        $this->loadRankingUsuarios();
        $this->loadTicketsCanal();
        $this->loadTicketsTipoSolicitud();
        //$this->loadDerivacionesPorArea();
        //$this->loadDerivacionesPorFecha();
        //$this->loadTiempoCierrePorDia();
    }

    private function loadTicketsEstado()
    {
        $data = Ticket::select('estado_ticket_id', DB::raw('count(*) as total'))
            ->groupBy('estado_ticket_id')
            ->get();

        $this->ticketsPorEstado = [
            'labels' => $data->map(fn($i) => EstadoTicket::find($i->estado_ticket_id)?->nombre ?? 'Desconocido'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadTicketsArea()
    {
        $data = Ticket::select('area_id', DB::raw('count(*) as total'))
            ->groupBy('area_id')
            ->get();

        $this->ticketsPorArea = [
            'labels' => $data->map(fn($i) => Area::find($i->area_id)?->nombre ?? 'Sin área'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadTicketsFecha()
    {
        $data = Ticket::select(DB::raw('DATE(created_at) as fecha'), DB::raw('count(*) as total'))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->take(15)
            ->get();

        $this->ticketsPorFecha = [
            'labels' => $data->pluck('fecha'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadRankingUsuarios()
    {
        $data = Ticket::select('usuario_asignado_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('usuario_asignado_id')
            ->groupBy('usuario_asignado_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $this->rankingUsuarios = [
            'labels' => $data->map(fn($i) => \App\Models\User::find($i->usuario_asignado_id)->name ?? 'Usuario'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadTicketsCanal()
    {
        $data = Ticket::select('canal_id', DB::raw('count(*) as total'))
            ->groupBy('canal_id')
            ->get();

        $this->ticketsPorCanal = [
            'labels' => $data->map(fn($i) => \App\Models\Canal::find($i->canal_id)?->nombre ?? 'Sin canal'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadTicketsTipoSolicitud()
    {
        $data = Ticket::select('tipo_solicitud_id', DB::raw('count(*) as total'))
            ->groupBy('tipo_solicitud_id')
            ->get();

        $this->ticketsPorTipo = [
            'labels' => $data->map(fn($i) => \App\Models\TipoSolicitud::find($i->tipo_solicitud_id)?->nombre ?? 'Otros'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadDerivacionesPorArea()
    {
        $data = \App\Models\TicketDerivado::select('a_area_id', DB::raw('count(*) as total'))
            ->groupBy('a_area_id')
            ->get();

        $this->derivacionesPorArea = [
            'labels' => $data->map(fn($i) => \App\Models\Area::find($i->a_area_id)?->nombre ?? 'Sin área'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadDerivacionesPorFecha()
    {
        $data = \App\Models\TicketDerivado::select(
            DB::raw('DATE(created_at) as fecha'),
            DB::raw('count(*) as total')
        )
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->take(15)
            ->get();

        $this->derivacionesPorFecha = [
            'labels' => $data->pluck('fecha'),
            'data'   => $data->pluck('total'),
        ];
    }

    private function loadTiempoCierrePorDia()
    {
        $data = Ticket::select(
            DB::raw("DATE(updated_at) as fecha"),
            DB::raw("AVG(TIMESTAMPDIFF(MINUTE, created_at, updated_at)) as minutos")
        )
            ->whereColumn('updated_at', '!=', 'created_at')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->take(15)
            ->get();

        $this->tiempoCierrePorDia = [
            'labels' => $data->pluck('fecha'),
            'data'   => $data->pluck('minutos'),
        ];
    }

    public function render()
    {
        return view('livewire.atc.reporte.reporte-livewire');
    }
}
