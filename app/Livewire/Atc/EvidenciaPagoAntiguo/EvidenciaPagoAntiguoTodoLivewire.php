<?php

namespace App\Livewire\Atc\EvidenciaPagoAntiguo;

use App\Models\EstadoEvidenciaPago;
use App\Models\EvidenciaPagoAntiguo;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoAntiguoTodoLivewire extends Component
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

    public function updatingPerPage()
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
        $evidencias = EvidenciaPagoAntiguo::query()
            ->when($this->buscar, function ($query) {
                $query->where(function ($q) {
                    $q->where('id', 'like', "%{$this->buscar}%")
                        ->orWhere('codigo_cliente', 'like', "%{$this->buscar}%")
                        ->orWhere('nombres_cliente', 'like', "%{$this->buscar}%");
                });
            })
            ->when($this->estado_id, function ($q) {
                $q->where('estado_evidencia_pago_id', $this->estado_id);
            })
            ->when($this->unidad_negocio_id, fn($q) => $q->where('unidad_negocio_id', $this->unidad_negocio_id))
            ->when($this->proyecto_id, fn($q) => $q->where('proyecto_id', $this->proyecto_id))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.evidencia-pago-antiguo.evidencia-pago-antiguo-todo-livewire', compact('evidencias'));
    }
}
