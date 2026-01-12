<?php

namespace App\Livewire\Atc\Cita;

use App\Models\Cita;
use App\Models\UnidadNegocio;
use App\Models\Proyecto;
use App\Models\Area;
use App\Models\EstadoCita;
use App\Models\MotivoCita;
use App\Models\Sede;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\CitasExport;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.admin.layout-admin')]
class CitaTodoLivewire extends Component
{
    use WithPagination;

    public $empresas, $unidad_negocio_id = '';
    public $proyectos = [], $proyecto_id = '';

    public $sedes, $sede_id = '';
    public $motivos, $motivo_cita_id = '';
    public $estados, $estado_cita_id = '';
    public $usuarios_admin, $admin = '';
    public $areas, $area = '';

    public $buscar = '';

    public $fecha_inicio = '';
    public $fecha_fin = '';

    public $perPage = 20;

    public function updating($field)
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->sedes = Sede::all();
        $this->estados = EstadoCita::all();
        $this->motivos = MotivoCita::all();
        $this->usuarios_admin = User::role(['asesor-atc', 'supervisor-atc'])->get();
        $this->areas = Area::all();

        $this->empresas = UnidadNegocio::all();
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

    public function resetFiltros()
    {
        $this->reset([
            'buscar',
            'unidad_negocio_id',
            'proyecto_id',
            'sede_id',
            'area',
            'motivo_cita_id',
            'admin',
            'estado_cita_id',
            'fecha_inicio',
            'fecha_fin',
            'perPage',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function exportExcel()
    {
        return Excel::download(
            new CitasExport(
                $this->buscar,
                $this->unidad_negocio_id,
                $this->proyecto_id,
                $this->sede_id,
                $this->area,
                $this->motivo_cita_id,
                $this->admin,
                $this->estado_cita_id,
                $this->fecha_inicio,
                $this->fecha_fin,
                $this->perPage,
                $this->getPage(),
            ),
            'citas.xlsx'
        );
    }

    public function render()
    {
        $items = Cita::query()
            ->when($this->buscar, function ($query) {
                $query->where(function ($q) {
                    $q->where('id', 'like', "%{$this->buscar}%")
                        ->orWhere('dni', 'like', "%{$this->buscar}%")
                        ->orWhere('nombres', 'like', "%{$this->buscar}%");
                });
            })
            ->when($this->unidad_negocio_id, fn($q) => $q->where('unidad_negocio_id', $this->unidad_negocio_id))
            ->when($this->proyecto_id, fn($q) => $q->where('proyecto_id', $this->proyecto_id))
            ->when($this->sede_id, fn($q) => $q->where('sede_id', $this->sede_id))
            ->when($this->motivo_cita_id, fn($q) => $q->where('motivo_cita_id', $this->motivo_cita_id))
            ->when($this->admin, fn($q) => $q->where('usuario_crea_id', $this->admin))
            ->when($this->estado_cita_id, fn($q) => $q->where('estado_cita_id', $this->estado_cita_id))

            ->when(
                $this->fecha_inicio,
                fn($q) =>
                $q->whereDate('fecha_inicio', '>=', $this->fecha_inicio)
            )
            ->when(
                $this->fecha_fin,
                fn($q) =>
                $q->whereDate('fecha_inicio', '<=', $this->fecha_fin)
            )

            ->orderBy('fecha_inicio', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.cita.cita-todo-livewire', compact('items'));
    }
}
