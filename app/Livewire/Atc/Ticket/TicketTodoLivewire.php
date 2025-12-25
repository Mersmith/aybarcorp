<?php

namespace App\Livewire\Atc\Ticket;

use App\Models\Ticket;
use App\Models\EstadoTicket;
use App\Models\Area;
use App\Models\User;
use App\Models\TipoSolicitud;
use App\Models\PrioridadTicket;
use App\Models\Canal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class TicketTodoLivewire extends Component
{
    use WithPagination;

    public $estados;
    public $areas;
    public $solicitudes;
    public $canales;
    public $usuarios_admin;
    public $prioridades = [];

    public $prioridad = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';
    public $admin = '';
    public $buscar = '';
    public $estado = '';
    public $area = '';
    public $solicitud = '';
    public $canal = '';
    public $perPage = 20;
    public $con_derivados = '';

    public function mount()
    {
        $this->estados = EstadoTicket::all();
        $this->areas = Area::all();
        $this->solicitudes = TipoSolicitud::all();
        $this->canales = Canal::all();
        $this->usuarios_admin = User::role(['atc', 'supervisor atc'])->get();
        $this->prioridades = PrioridadTicket::all();
        $this->admin = Auth::check() ? Auth::id() : '';
        $this->fecha_inicio = now()->toDateString(); // "2025-11-26"
        $this->fecha_fin = now()->toDateString();
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }
    public function updatingEstado()
    {
        $this->resetPage();
    }
    public function updatingArea()
    {
        $this->resetPage();
    }
    public function updatingSolicitud()
    {
        $this->resetPage();
    }
    public function updatingCanal()
    {
        $this->resetPage();
    }

    public function updatingAdmin()
    {
        $this->resetPage();
    }

    public function updatingFechaInicio()
    {
        $this->resetPage();
    }

    public function updatingFechaFin()
    {
        $this->resetPage();
    }

    public function updatingPrioridad()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset([
            'fecha_inicio',
            'fecha_fin',
            'admin',
            'buscar',
            'estado',
            'area',
            'solicitud',
            'canal',
            'perPage',
            'prioridad',
            'con_derivados',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function render()
    {
        $tickets = Ticket::query()
            ->when($this->buscar, function ($query) {
                $query->where('id', 'like', "%{$this->buscar}%")
                    ->orWhereHas('cliente', function ($q) {
                        $q->where('name', 'like', "%{$this->buscar}%");
                    })
                    ->orWhereHas('cliente.cliente', function ($q) {
                        $q->where('dni', 'like', "%{$this->buscar}%")
                            ->orWhere('nombre_completo', 'like', "%{$this->buscar}%");
                    });
            })
            ->when($this->estado, fn($q) => $q->where('estado_ticket_id', $this->estado))
            ->when($this->area, fn($q) => $q->where('area_id', $this->area))
            ->when($this->solicitud, fn($q) => $q->where('tipo_solicitud_id', $this->solicitud))
            ->when($this->canal, fn($q) => $q->where('canal_id', $this->canal))
            ->when($this->admin, fn($q) => $q->where('usuario_asignado_id', $this->admin))
            ->when(
                $this->fecha_inicio,
                fn($q) =>
                $q->whereDate('created_at', '>=', $this->fecha_inicio)
            )
            ->when(
                $this->fecha_fin,
                fn($q) =>
                $q->whereDate('created_at', '<=', $this->fecha_fin)
            )
            ->when($this->prioridad, fn($q) => $q->where('prioridad_ticket_id', $this->prioridad))
            ->when(
                $this->con_derivados === '1',
                fn($q) =>
                $q->whereHas('derivados')
            )
            ->when(
                $this->con_derivados === '0',
                fn($q) =>
                $q->whereDoesntHave('derivados')
            )
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.ticket.ticket-todo-livewire', compact('tickets'));
    }
}
