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
use Illuminate\Validation\ValidationException;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoAntiguoEditarLivewire extends Component
{
    use AuthorizesRequests;
    public $evidencia;
    public $estados, $estado_id = '';

    public $observacion;

    public $empresas, $unidad_negocio_id = '';
    public $proyectos = [], $proyecto_id = '';

    public $gestores = [], $gestor_id = "";

    protected function rules()
    {
        return [
            'estado_id' => 'required',
            'unidad_negocio_id' => 'required',
            'proyecto_id' => 'required',
            'gestor_id' => 'required',
            'observacion' => 'required',
        ];
    }

    public function mount($id)
    {
        $this->evidencia = EvidenciaPagoAntiguo::findOrFail($id);
        $this->estado_id = $this->evidencia->estado_evidencia_pago_id;
        $this->observacion = $this->evidencia->observacion;
        $this->unidad_negocio_id = $this->evidencia->unidad_negocio_id;
        $this->proyecto_id = $this->evidencia->proyecto_id;
        $this->gestor_id = $this->evidencia->gestor_id ?? '';

        $this->estados = EstadoEvidenciaPago::all();
        $this->empresas = UnidadNegocio::all();
        $this->loadProyectos();

        $this->gestores = User::role('asesor-backoffice')
            ->where('rol', 'admin')
            ->get();
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
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->evidencia->update([
            'estado_evidencia_pago_id' => $this->estado_id,
            'unidad_negocio_id' => $this->unidad_negocio_id,
            'proyecto_id' => $this->proyecto_id,
            'gestor_id' => $this->gestor_id,
            'observacion' => $this->observacion,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    public function validar()
    {
        $this->authorize('evidencia-pago-validar');

        $estadoAprobadoId = EstadoEvidenciaPago::id(
            EstadoEvidenciaPago::APROBADO
        );

        $this->evidencia->update([
            'estado_evidencia_pago_id' => $estadoAprobadoId,
            'usuario_valida_id'        => auth()->id(),
            'fecha_validacion'         => now(),
        ]);

        $this->estado_id = $estadoAprobadoId;

        $this->evidencia->refresh();

        $this->dispatch('alertaLivewire', [
            'title' => 'Validado',
            'text'  => 'Se validó correctamente.',
        ]);
    }


    public function render()
    {
        return view('livewire.atc.evidencia-pago-antiguo.evidencia-pago-antiguo-editar-livewire');
    }
}
