<?php

namespace App\Livewire\Atc\EvidenciaPago;

use App\Models\SolicitudEvidenciaPago;
use App\Models\EstadoEvidenciaPago;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoTodoLivewire extends Component
{
    use WithPagination;
    public $buscar = '';
    public $perPage = 20;
    public $estados, $estado_id = '';
    public $empresas, $unidad_negocio_id = '';
    public $proyectos, $proyecto_id = '';
    public $usuarios_admin, $admin = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';

    public function mount()
    {
        $this->estados = EstadoEvidenciaPago::all();
        $this->empresas = UnidadNegocio::all();
        $this->proyectos = Proyecto::all();
        $this->usuarios_admin = User::role(['asesor-atc', 'supervisor-atc'])->get();
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
            'admin',
            'fecha_inicio',
            'fecha_fin',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function render()
    {
        $evidencias = SolicitudEvidenciaPago::query()
            ->with(['userCliente.cliente', 'estado'])
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
                $this->estado_id,
                fn($q) =>
                $q->where('estado_evidencia_pago_id', $this->estado_id)
            )
            ->when($this->admin, fn($q) => $q->where('gestor_id', $this->admin))
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
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.evidencia-pago.evidencia-pago-todo-livewire', compact('evidencias'));
    }
}
