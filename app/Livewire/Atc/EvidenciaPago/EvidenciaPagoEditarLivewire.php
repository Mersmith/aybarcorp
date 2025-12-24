<?php

namespace App\Livewire\Atc\EvidenciaPago;

use App\Models\EvidenciaPago;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use App\Models\EstadoEvidenciaPago;
use Livewire\Attributes\Layout;
use App\Mail\EvidenciaPagoObservacionMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoEditarLivewire extends Component
{
    use AuthorizesRequests;
    public $comprobante;
    public $estados, $estado_id = '';

    public $observacion;

    public $empresas, $unidad_negocio_id = '';
    public $proyectos = [], $proyecto_id = '';

    protected function rules()
    {
        return [
            'estado_id' => 'required',
            'unidad_negocio_id' => 'required',
            'proyecto_id' => 'required',
        ];
    }

    public function mount($id)
    {
        $this->comprobante = EvidenciaPago::findOrFail($id);
        $this->estado_id = $this->comprobante->estado_comprobante_pago_id;
        $this->observacion = $this->comprobante->observacion;
        $this->unidad_negocio_id = $this->comprobante->unidad_negocio_id;
        $this->proyecto_id = $this->comprobante->proyecto_id;

        $this->estados = EstadoEvidenciaPago::all();
        $this->empresas = UnidadNegocio::all();
        $this->loadProyectos();
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

        $this->comprobante->update([
            'estado_comprobante_pago_id' => $this->estado_id,
            'unidad_negocio_id' => $this->unidad_negocio_id,
            'proyecto_id' => $this->proyecto_id,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    public function validar()
    {
        $this->authorize('evidencia-pago-validar');
        $this->comprobante->update([
            'usuario_valida_id' => auth()->id(),
            'fecha_validacion' => now(),
        ]);
        $this->comprobante->refresh();
        $this->dispatch('alertaLivewire', "Validado");
    }

    public function enviarCorreo()
    {
        $this->validate([
            'observacion' => 'required',
        ]);

        $this->comprobante->update([
            'observacion' => $this->observacion,
        ]);

        $emailDestino = $this->comprobante->cliente->email;

        Mail::to($emailDestino)
            ->send(new EvidenciaPagoObservacionMail($this->comprobante));

        $this->dispatch('alertaLivewire', "Enviado");
    }

    public function render()
    {
        return view('livewire.atc.comprobante-pago.comprobante-pago-editar-livewire');
    }
}
