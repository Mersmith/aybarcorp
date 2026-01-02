<?php

namespace App\Livewire\Atc\EvidenciaPago;

use App\Models\EvidenciaPago;
use App\Models\EstadoEvidenciaPago;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoTodoLivewire extends Component
{
    use WithPagination;
    public $buscar = '';
    public $perPage = 20;
    public $estados, $estado_id = '';
    public $empresas, $unidad_negocio_id = '';
    public $proyectos, $proyecto_id = '';

    public function mount()
    {
        $this->estados = EstadoEvidenciaPago::all();
        $this->empresas = UnidadNegocio::all();
        $this->proyectos = Proyecto::all();
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function updatingEstadoId()
    {
        $this->resetPage();
    }

    public function updatingUnidadNegocioId()
    {
        $this->resetPage();
    }

    public function updatingProyectoId()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset([
            'estado_id',
            'unidad_negocio_id',
            'proyecto_id',
            'buscar',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function render()
    {
        $evidencias = EvidenciaPago::query()
            ->with(['cliente.user', 'estado'])
            ->when($this->buscar, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('id', 'like', "%{$this->buscar}%")
                        ->orWhereHas('cliente.user', function ($sub2) {
                            $sub2->where('name', 'like', "%{$this->buscar}%");
                        })
                        ->orWhereHas('cliente', function ($sub3) {
                            $sub3->where('dni', 'like', "%{$this->buscar}%");
                        });
                });
            })
            ->when($this->estado_id, function ($q) {
                $q->where('estado_evidencia_pago_id', $this->estado_id);
            })
            ->when($this->unidad_negocio_id, fn($q) => $q->where('unidad_negocio_id', $this->unidad_negocio_id))
            ->when($this->proyecto_id, fn($q) => $q->where('proyecto_id', $this->proyecto_id))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.evidencia-pago.evidencia-pago-todo-livewire', compact('evidencias'));
    }
}
