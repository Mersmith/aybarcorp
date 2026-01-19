<?php

namespace App\Livewire\Cavali\SolicitarLetraDigital;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SolicitudDigitalizarLetra;

#[Layout('layouts.admin.layout-admin')]
class SolicitarLetraDigitalTodoLivewire extends Component
{
    use WithPagination;

    public $buscar = '';
    public $perPage = 20;
    public $empresas, $unidad_negocio_id = '';
    public $proyectos, $proyecto_id = '';

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset(['buscar']);
        $this->perPage = 20;
        $this->resetPage();
    }

    public function render()
    {
        $items = SolicitudDigitalizarLetra::query()
            ->with(['userCliente.cliente'])
            ->when($this->buscar, function ($q) {
                $buscar = $this->buscar;

                $q->where(function ($sub) use ($buscar) {

                    $sub->where('solicitud_evidencia_pagos.id', 'like', "%{$buscar}%")

                        ->orWhereHas('userCliente', function ($qUser) use ($buscar) {
                            $qUser->where('name', 'like', "%{$buscar}%");
                        })

                        ->orWhereHas('userCliente.cliente', function ($qCliente) use ($buscar) {
                            $qCliente->where('dni', 'like', "%{$buscar}%");
                        });
                });
            })
            ->when(
                $this->unidad_negocio_id,
                fn($q) =>
                $q->where('unidad_negocio_id', $this->unidad_negocio_id)
            )
            ->when(
                $this->proyecto_id,
                fn($q) =>
                $q->where('proyecto_id', $this->proyecto_id)
            )
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.cavali.solicitar-letra-digital.solicitar-letra-digital-todo-livewire', compact('items'));
    }
}
