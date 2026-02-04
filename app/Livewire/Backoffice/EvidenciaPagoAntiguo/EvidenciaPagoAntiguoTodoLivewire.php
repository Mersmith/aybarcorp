<?php

namespace App\Livewire\Backoffice\EvidenciaPagoAntiguo;

use App\Models\EstadoEvidenciaPago;
use App\Models\EvidenciaPagoAntiguo;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\EvidenciaPagoAntiguoExport;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoAntiguoTodoLivewire extends Component
{
    use WithPagination;
    public $buscar = '';
    public $buscar_lote = '';
    public $perPage = 20;
    public $estados, $estado_id = '';
    public $empresas, $unidad_negocio_id = '';
    public $proyectos, $proyecto_id = '';
    public $tiene_fecha_deposito = '';
    public $tiene_imagen = '';
    public $tiene_numero_operacion = '';
    public $tiene_codigo_cuenta = '';

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
    public function updatingBuscarLote()
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

    public function updatingTieneFechaDeposito()
    {
        $this->resetPage();
    }

    public function updatingTieneImagen()
    {
        $this->resetPage();
    }

    public function updatingTieneNumeroOperacion()
    {
        $this->resetPage();
    }

    public function updatingTieneCodigoCuenta()
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
            'buscar_lote',
            'tiene_fecha_deposito',
            'tiene_imagen',
            'tiene_numero_operacion',
            'tiene_codigo_cuenta',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function exportExcel()
    {
        return Excel::download(
            new EvidenciaPagoAntiguoExport(
                $this->buscar,
                $this->buscar_lote,
                $this->unidad_negocio_id,
                $this->proyecto_id,
                $this->estado_id,
                $this->tiene_fecha_deposito,
                $this->tiene_imagen,
                $this->tiene_numero_operacion,
                $this->tiene_codigo_cuenta,
                $this->perPage,
                $this->getPage(),
            ),
            'evidencia_pago_antiguo.xlsx'
        );
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
            ->when($this->buscar_lote, function ($query, $buscar_lote) {
                $query->where('lote', 'like', "%{$buscar_lote}%");
            })
            ->when($this->estado_id, function ($q) {
                $q->where('estado_evidencia_pago_id', $this->estado_id);
            })
            ->when($this->unidad_negocio_id, fn($q) => $q->where('unidad_negocio_id', $this->unidad_negocio_id))
            ->when($this->proyecto_id, fn($q) => $q->where('proyecto_id', $this->proyecto_id))
            ->when($this->tiene_fecha_deposito !== '', function ($q) {
                if ($this->tiene_fecha_deposito === 'si') {
                    $q->whereNotNull('fecha_deposito');
                }

                if ($this->tiene_fecha_deposito === 'no') {
                    $q->whereNull('fecha_deposito');
                }
            })
            ->when($this->tiene_imagen !== '', function ($q) {
                if ($this->tiene_imagen === 'si') {
                    $q->whereNotNull('imagen_url');
                }

                if ($this->tiene_imagen === 'no') {
                    $q->whereNull('imagen_url');
                }
            })
            ->when($this->tiene_numero_operacion !== '', function ($q) {
                if ($this->tiene_numero_operacion === 'si') {
                    $q->whereNotNull('operacion_numero');
                }

                if ($this->tiene_numero_operacion === 'no') {
                    $q->whereNull('operacion_numero');
                }
            })
            ->when($this->tiene_codigo_cuenta !== '', function ($q) {
                if ($this->tiene_codigo_cuenta === 'si') {
                    $q->whereNotNull('codigo_cuenta');
                }

                if ($this->tiene_codigo_cuenta === 'no') {
                    $q->whereNull('codigo_cuenta');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.backoffice.evidencia-pago-antiguo.evidencia-pago-antiguo-todo-livewire', compact('evidencias'));
    }
}
