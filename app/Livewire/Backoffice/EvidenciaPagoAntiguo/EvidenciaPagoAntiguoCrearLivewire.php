<?php

namespace App\Livewire\Backoffice\EvidenciaPagoAntiguo;

use App\Models\EstadoEvidenciaPago;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\EvidenciaPagoAntiguo;
use Illuminate\Validation\ValidationException;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoAntiguoCrearLivewire extends Component
{
    public $empresas, $unidad_negocio_id = '';
    public $proyectos = [], $proyecto_id = '';
    public $gestores, $gestor_id = '';
    public $estados, $estado_evidencia_pago_id = '';

    public $etapa = '';
    public $lote = '';
    public $numero_cuota = '';

    public $operacion_numero = '';
    public $monto = '';
    public $fecha_deposito = '';

    public $dni_cliente = '';
    public $codigo_cliente = '';
    public $nombres_cliente = '';

    public $imagen_url = '';

    protected function rules()
    {
        return [
            'unidad_negocio_id' => 'required',
            'proyecto_id' => 'required',
            'gestor_id' => 'required',
            'estado_evidencia_pago_id' => 'required',
            'etapa' => 'required',
            'lote' => 'required',
            'numero_cuota' => 'required',
            'operacion_numero' => 'required',
            'monto' => 'required|numeric|min:0',
            'fecha_deposito' => 'required',
            'dni_cliente' => 'required',
            'codigo_cliente' => 'required',
            'nombres_cliente' => 'required',
            'imagen_url' => 'required',
        ];
    }

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

        EvidenciaPagoAntiguo::create([
            'unidad_negocio_id' => $this->unidad_negocio_id,
            'proyecto_id' => $this->proyecto_id,
            'gestor_id' => $this->gestor_id,
            'estado_evidencia_pago_id' => $this->estado_evidencia_pago_id,
            'etapa' => $this->etapa,
            'lote' => $this->lote,
            'numero_cuota' => $this->numero_cuota,
            'operacion_numero' => $this->operacion_numero,
            'monto' => $this->monto,
            'fecha_deposito' => $this->fecha_deposito,
            'dni_cliente' => $this->dni_cliente,
            'codigo_cliente' => $this->codigo_cliente,
            'nombres_cliente' => $this->nombres_cliente,
            'imagen_url' => $this->imagen_url,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Creado', 'text' => 'Se guardó correctamente.']);

        return redirect()->route('admin.evidencia-pago-antiguo.vista.todo');
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
        return view('livewire.backoffice.evidencia-pago-antiguo.evidencia-pago-antiguo-crear-livewire');
    }
}
