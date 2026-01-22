<?php

namespace App\Livewire\Backoffice\EvidenciaPago;

use App\Models\EstadoEvidenciaPago;
use App\Models\Proyecto;
use App\Models\SolicitudEvidenciaPago;
use App\Models\UnidadNegocio;
use App\Models\User;
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
    public $usuarios_admin, $admin = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';
    public $tipo_cierre = '';
    public $tiene_validacion = '';
    public $es_asbanc = '';

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

    public function updatingTipoCierre()
    {
        $this->resetPage();
    }

    public function updatingTieneValidacion()
    {
        $this->resetPage();
    }

    public function updatingEsAsbanc()
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
            'tipo_cierre',
            'tiene_validacion',
            'es_asbanc',
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
            ->when($this->admin, function ($q) {
                if ($this->admin === 'sin_asignar') {
                    $q->whereNull('gestor_id');
                } else {
                    $q->where('gestor_id', $this->admin);
                }
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
            ->when($this->tipo_cierre, function ($q) {
                if ($this->tipo_cierre === 'api') {
                    $q->where('slin_evidencia', true);
                }

                if ($this->tipo_cierre === 'manual') {
                    $q->where('resuelto_manual', true);
                }
            })
            ->when($this->tiene_validacion !== '', function ($q) {
                if ($this->tiene_validacion === 'si') {
                    $q->whereNotNull('fecha_validacion');
                }

                if ($this->tiene_validacion === 'no') {
                    $q->whereNull('fecha_validacion');
                }
            })
            ->when($this->es_asbanc !== '', function ($q) {
                if ($this->es_asbanc === 'si') {
                    $q->where('slin_asbanc', true);
                }

                if ($this->es_asbanc === 'no') {
                    $q->where('slin_asbanc', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.backoffice.evidencia-pago.evidencia-pago-todo-livewire', compact('evidencias'));
    }
}
