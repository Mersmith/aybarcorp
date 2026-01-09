<?php

namespace App\Livewire\Atc\EvidenciaPago;

use App\Mail\EvidenciaPagoObservacionMail;
use App\Models\EstadoEvidenciaPago;
use App\Models\EvidenciaPago;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoEditarLivewire extends Component
{
    use AuthorizesRequests;
    public $evidencia;
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
        $this->evidencia = EvidenciaPago::findOrFail($id);
        $this->estado_id = $this->evidencia->estado_evidencia_pago_id;
        $this->observacion = $this->evidencia->observacion;
        $this->unidad_negocio_id = $this->evidencia->unidad_negocio_id;
        $this->proyecto_id = $this->evidencia->proyecto_id;

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

        $this->evidencia->update([
            'estado_evidencia_pago_id' => $this->estado_id,
            'unidad_negocio_id' => $this->unidad_negocio_id,
            'proyecto_id' => $this->proyecto_id,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    public function validar()
    {
        $this->authorize('evidencia-pago-validar');
        $this->evidencia->update([
            'usuario_valida_id' => auth()->id(),
            'fecha_validacion' => now(),
        ]);
        $this->evidencia->refresh();
        $this->dispatch('alertaLivewire', ['title' => 'Validado', 'text' => 'Se validó correctamente.']);
    }

    public function enviarSlin()
    {
        // 1. Verificar archivo
        if (!Storage::disk('public')->exists($this->evidencia->path)) {
            $this->dispatch('alertaLivewire', 'Error');
            return;
        }

        // 2. Obtener imagen
        $imageContent = Storage::disk('public')->get($this->evidencia->path);

        // 3. Payload EXACTO como lo pide el proveedor
        $params = [
            'lote' => (string) $this->evidencia->lote_completo,
            'cliente' => (string) $this->evidencia->codigo_cliente,
            'contrato' => '', // nullable|string → enviar vacío
            'idcobranzas' => (string) $this->evidencia->transaccion_id,
            'base64Image' => base64_encode($imageContent),
        ];

        // 4. Llamada al backend del proveedor
        $response = Http::acceptJson()
            ->contentType('application/json')
            ->timeout(30)
            ->post(
                'https://aybarcorp.com/api/slin/guardar-evidencia',
                $params
            );

        // 5. Manejo de error
        if ($response->failed()) {
            logger()->error('Error SLIN', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            $this->dispatch('alertaLivewire', 'Error');
            return;
        }

        // 6. Marcar como enviado
        $this->evidencia->update([
            'enviado_slin' => true,
            'fecha_envio_slin' => now(),
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Enviado', 'text' => 'Se envió correctamente.']);
    }

    public function enviarCorreo()
    {
        $this->validate([
            'observacion' => 'required',
        ]);

        $this->evidencia->update([
            'observacion' => $this->observacion,
        ]);

        $emailDestino = $this->evidencia->userCliente->email;

        Mail::to($emailDestino)
            ->send(new EvidenciaPagoObservacionMail($this->evidencia));

            $this->dispatch('alertaLivewire', ['title' => 'Enviado', 'text' => 'Se envió correctamente.']);
        }

    public function render()
    {
        return view('livewire.atc.evidencia-pago.evidencia-pago-editar-livewire');
    }
}
