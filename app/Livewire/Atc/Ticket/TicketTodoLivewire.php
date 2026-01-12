<?php

namespace App\Livewire\Atc\Ticket;

use App\Exports\TicketsExport;
use App\Models\Area;
use App\Models\Canal;
use App\Models\EstadoTicket;
use App\Models\PrioridadTicket;
use App\Models\Proyecto;
use App\Models\SubTipoSolicitud;
use App\Models\Ticket;
use App\Models\TipoSolicitud;
use App\Models\UnidadNegocio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.admin.layout-admin')]
class TicketTodoLivewire extends Component
{
    use WithPagination;

    public $estados, $estado = '';
    public $areas, $area = '';
    public $solicitudes, $solicitud = '';
    public $sub_tipos_solicitudes = [], $sub_tipo_solicitud_id = "";
    public $canales, $canal = '';
    public $usuarios_admin, $admin = '';
    public $prioridades, $prioridad = '';
    public $empresas, $unidad_negocio_id = '';
    public $proyectos = [], $proyecto_id = '';

    public $fecha_inicio = '';
    public $fecha_fin = '';
    public $buscar = '';
    public $con_derivados = '';
    public $con_citas = '';
    public $perPage = 20;

    public function mount()
    {
        $this->estados = EstadoTicket::all();
        $this->areas = Area::all();
        $this->solicitudes = TipoSolicitud::all();
        $this->canales = Canal::all();
        $this->usuarios_admin = User::role(['asesor-atc', 'supervisor-atc'])->get();
        $this->prioridades = PrioridadTicket::all();
        $this->admin = Auth::check() ? Auth::id() : '';
        $this->fecha_inicio = now()->toDateString(); // "2025-11-26"
        $this->fecha_fin = now()->toDateString();

        $this->empresas = UnidadNegocio::all();
    }

    public function exportExcel()
    {
        return Excel::download(
            new TicketsExport(
                $this->buscar,
                $this->unidad_negocio_id,
                $this->proyecto_id,
                $this->estado,
                $this->area,
                $this->solicitud,
                $this->sub_tipo_solicitud_id,
                $this->canal,
                $this->admin,
                $this->prioridad,
                $this->fecha_inicio,
                $this->fecha_fin,
                $this->con_derivados,
                $this->con_citas,
                $this->perPage,
                $this->getPage(),
            ),
            'tickets.xlsx'
        );
    }

    public function updatedUnidadNegocioId($value)
    {
        $this->proyecto_id = '';
        $this->proyectos = [];

        if ($value) {
            $this->loadProyectos();
        }
    }

    public function loadProyectos()
    {
        if (!is_null($this->unidad_negocio_id)) {
            $this->proyectos = Proyecto::where('unidad_negocio_id', $this->unidad_negocio_id)->get();
        }
    }

    public function updatedSolicitud($value)
    {
        $this->sub_tipo_solicitud_id = '';
        $this->sub_tipos_solicitudes = [];

        if ($value) {
            $this->loadSubTipoSolicitudes();
        }
    }

    public function loadSubTipoSolicitudes()
    {
        if (!is_null($this->solicitud)) {
            $this->sub_tipos_solicitudes = SubTipoSolicitud::where('tipo_solicitud_id', $this->solicitud)->get();
        }
    }

    public function updatingUnidadNegocioId()
    {
        $this->resetPage();
    }

    public function updatingProyectoId()
    {
        $this->resetPage();
    }

    public function updatingSubTipoSolicitudId()
    {
        $this->resetPage();
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

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset([
            'unidad_negocio_id',
            'proyecto_id',
            'fecha_inicio',
            'fecha_fin',
            'admin',
            'buscar',
            'estado',
            'area',
            'solicitud',
            'sub_tipo_solicitud_id',
            'canal',
            'perPage',
            'prioridad',
            'con_derivados',
            'con_citas',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function render()
    {
        $items = Ticket::query()
            ->when($this->buscar, function ($query) {
                $query->where(function ($q) {
                    $q->where('id', 'like', "%{$this->buscar}%")
                        ->orWhere('dni', 'like', "%{$this->buscar}%")
                        ->orWhere('nombres', 'like', "%{$this->buscar}%");
                });
            })
            ->when($this->unidad_negocio_id, fn($q) => $q->where('unidad_negocio_id', $this->unidad_negocio_id))
            ->when($this->proyecto_id, fn($q) => $q->where('proyecto_id', $this->proyecto_id))
            ->when($this->estado, fn($q) => $q->where('estado_ticket_id', $this->estado))
            ->when($this->area, fn($q) => $q->where('area_id', $this->area))
            ->when($this->solicitud, fn($q) => $q->where('tipo_solicitud_id', $this->solicitud))
            ->when($this->sub_tipo_solicitud_id, fn($q) => $q->where('sub_tipo_solicitud_id', $this->sub_tipo_solicitud_id))
            ->when($this->canal, fn($q) => $q->where('canal_id', $this->canal))
            ->when($this->admin, fn($q) => $q->where('gestor_id', $this->admin))
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
            ->when(
                $this->con_citas === '1',
                fn($q) =>
                $q->whereHas('citas')
            )
            ->when(
                $this->con_citas === '0',
                fn($q) =>
                $q->whereDoesntHave('citas')
            )
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.ticket.ticket-todo-livewire', compact('items'));
    }
}
