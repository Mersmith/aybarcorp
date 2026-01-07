<?php

namespace App\Livewire\Atc\EvidenciaPagoAntiguo;

use App\Models\EstadoEvidenciaPago;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoAntiguoCrearLivewire extends Component
{
    public $empresas, $unidad_negocio_id = '';
    public $proyectos = [], $proyecto_id = '';
    public $gestores, $gestor_id = '';
    public $estados, $estado_id = '';

    public $etapa = '';
    public $lote = '';
    public $numero_cuota = '';
    public $operacion_numero = '';
    public $monto = '';

    public function mount()
    {
        $this->empresas = UnidadNegocio::all();
        $this->estados = EstadoEvidenciaPago::all();
        $this->gestores = User::role('asesor-atc')
            ->where('rol', 'admin')
            ->get();
    }

    public function store()
    {
        $this->validate();

    }

    public function updatedUnidadNegocioId($value)
    {
        $this->proyecto_id = '';

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

    public function render()
    {
        return view('livewire.atc.evidencia-pago-antiguo.evidencia-pago-antiguo-crear-livewire');
    }
}
