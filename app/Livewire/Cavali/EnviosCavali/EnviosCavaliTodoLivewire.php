<?php

namespace App\Livewire\Cavali\EnviosCavali;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EnvioCavali;
use App\Models\UnidadNegocio;

#[Layout('layouts.admin.layout-admin')]
class EnviosCavaliTodoLivewire extends Component
{
    use WithPagination;

    public $buscar = '';
    public $perPage = 20;
    public $estado = '';
    public $unidad_negocio_id = '';

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingEstado()
    {
        $this->resetPage();
    }

    public function updatingUnidadNegocioId()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset(['buscar', 'estado', 'unidad_negocio_id']);
        $this->perPage = 20;
        $this->resetPage();
    }

    public function render()
    {
        $items = EnvioCavali::query()
            ->with(['unidadNegocio', 'solicitudes'])
            ->withCount('solicitudes')
            ->when($this->buscar, function ($q) {
                $buscar = $this->buscar;

                $q->where(function ($sub) use ($buscar) {
                    $sub->where('fecha_corte', 'like', "%{$buscar}%")
                        ->orWhereHas('unidadNegocio', function ($qUnidad) use ($buscar) {
                            $qUnidad->where('razon_social', 'like', "%{$buscar}%")
                                ->orWhere('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->when($this->estado, fn($q) => $q->where('estado', $this->estado))
            ->when($this->unidad_negocio_id, fn($q) => $q->where('unidad_negocio_id', $this->unidad_negocio_id))
            ->orderBy('fecha_corte', 'desc')
            ->paginate($this->perPage);

        $unidadesNegocio = UnidadNegocio::orderBy('razon_social')->get();

        return view('livewire.cavali.envios-cavali.envios-cavali-todo-livewire', compact('items', 'unidadesNegocio'));
    }
}
