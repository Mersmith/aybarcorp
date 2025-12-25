<?php

namespace App\Livewire\Atc\Cita;

use App\Models\Cita;
use App\Models\EstadoCita;
use App\Models\MotivoCita;
use App\Models\Sede;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class CitaTodoLivewire extends Component
{
    use WithPagination;

    public $sedes, $sede_id = '';
    public $motivos, $motivo_cita_id = '';
    public $estados, $estado_cita_id = '';
    public $usuarios_admin, $usuario_solicita_id = '';

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
        $this->usuarios_admin = User::where('rol', 'admin')->get();
    }

    public function resetFiltros()
    {
        $this->reset([
            'sede_id',
            'motivo_cita_id',
            'usuario_solicita_id',
            'estado_cita_id',
            'buscar',
            'fecha_inicio',
            'fecha_fin',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function render()
    {
        $citas = Cita::query()
            ->when($this->buscar, function ($q) {
                $q->where('id', 'like', "%{$this->buscar}%")
                    ->orWhereHas('solicitante', function ($sub) {
                        $sub->where('name', 'like', "%{$this->buscar}%");
                    })
                    ->orWhereHas('receptor', function ($sub) {
                        $sub->where('name', 'like', "%{$this->buscar}%");
                    });
            })

            ->when($this->sede_id, fn($q) => $q->where('sede_id', $this->sede_id))
            ->when($this->motivo_cita_id, fn($q) => $q->where('motivo_cita_id', $this->motivo_cita_id))
            ->when($this->usuario_solicita_id, fn($q) => $q->where('usuario_solicita_id', $this->usuario_solicita_id))
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

        return view('livewire.atc.cita.cita-todo-livewire', compact('citas'));
    }
}
