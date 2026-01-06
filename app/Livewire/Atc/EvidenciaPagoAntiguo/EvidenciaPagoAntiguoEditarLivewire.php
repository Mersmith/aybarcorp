<?php

namespace App\Livewire\Atc\EvidenciaPagoAntiguo;

use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use App\Models\EstadoEvidenciaPago;
use Livewire\Attributes\Layout;
use App\Models\EvidenciaPagoAntiguo;
use App\Models\User;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoAntiguoEditarLivewire extends Component
{
    use AuthorizesRequests;
    public $evidencia;
    public $estados, $estado_id = '';

    public $observacion;

    public $empresas, $unidad_negocio_id = '';
    public $proyectos = [], $proyecto_id = '';

    public $usuarios = [], $usuario_asignado_id = "";

    protected function rules()
    {
        return [
            'estado_id' => 'required',
            'unidad_negocio_id' => 'required',
            'proyecto_id' => 'required',
            'usuario_asignado_id' => 'required',
        ];
    }

    public function mount($id)
    {
        $this->evidencia = EvidenciaPagoAntiguo::findOrFail($id);
        $this->estado_id = $this->evidencia->estado_evidencia_pago_id;
        $this->observacion = $this->evidencia->observacion;
        $this->unidad_negocio_id = $this->evidencia->unidad_negocio_id;
        $this->proyecto_id = $this->evidencia->proyecto_id;

        $this->estados = EstadoEvidenciaPago::all();
        $this->empresas = UnidadNegocio::all();
        $this->loadProyectos();

        $this->usuarios = User::role('asesor-atc')->get();
        $this->usuario_asignado_id = $this->evidencia->gestor_id;
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

    public function store()
    {
        $this->validate();

        $this->evidencia->update([
            'estado_evidencia_pago_id' => $this->estado_id,
            'unidad_negocio_id' => $this->unidad_negocio_id,
            'proyecto_id' => $this->proyecto_id,
            'gestor_id' => $this->usuario_asignado_id,
            'observacion' => $this->observacion,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    public function validar()
    {
        $this->authorize('evidencia-pago-validar');
        $this->evidencia->update([
            'usuario_valida_id' => auth()->id(),
            'fecha_validacion' => now(),
        ]);
        $this->evidencia->refresh();
        $this->dispatch('alertaLivewire', "Validado");
    }

    public function render()
    {
        return view('livewire.atc.evidencia-pago-antiguo.evidencia-pago-antiguo-editar-livewire');
    }
}
