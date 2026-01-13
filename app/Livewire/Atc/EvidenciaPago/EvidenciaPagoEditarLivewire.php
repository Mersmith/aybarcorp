<?php

namespace App\Livewire\Atc\EvidenciaPago;

use App\Mail\EvidenciaPagoObservacionMail;
use App\Models\EstadoEvidenciaPago;
use App\Models\EvidenciaPago;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
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

    public $gestores, $gestor_id = '';

    protected function rules()
    {
        return [
            'unidad_negocio_id' => 'required',
            'proyecto_id' => 'required',
            'gestor_id' => 'required',
            'estado_id' => 'required',
        ];
    }

    public function mount($id)
    {
        $this->evidencia = EvidenciaPago::findOrFail($id);
        $this->estado_id = $this->evidencia->estado_evidencia_pago_id;
        $this->observacion = $this->evidencia->observacion;
        $this->unidad_negocio_id = $this->evidencia->unidad_negocio_id;
        $this->proyecto_id = $this->evidencia->proyecto_id;
        $this->gestor_id = $this->evidencia->gestor_id;

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
            'unidad_negocio_id' => $this->unidad_negocio_id,
            'proyecto_id' => $this->proyecto_id,
            'gestor_id' => $this->gestor_id,
            'estado_evidencia_pago_id' => $this->estado_id,
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
        if (
            $this->evidencia->slin_asbanc === false
        ) {
            $this->dispatch('alertaLivewire', [
                'title' => 'Error',
                'text' => 'No es Asbanc o ya tiene evidencia',
            ]);
            return;
        }

        if (!Storage::disk('public')->exists($this->evidencia->path)) {
            $this->dispatch('alertaLivewire', 'Error');
            return;
        }

        $imageContent = Storage::disk('public')->get($this->evidencia->path);

        $params = [
            'lote' => (string) $this->evidencia->lote_completo,
            'cliente' => (string) $this->evidencia->codigo_cliente,
            'contrato' => '', // nullable|string → enviar vacío
            'idcobranzas' => (string) $this->evidencia->transaccion_id,
            'base64Image' => base64_encode($imageContent),
        ];

        $response = Http::acceptJson()
            ->contentType('application/json')
            ->timeout(30)
            ->post(
                'https://aybarcorp.com/api/slin/guardar-evidencia',
                $params
            );

        $body = $response->json();

        if ($response->failed()) {
            logger()->error('Error SLIN HTTP', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            $this->evidencia->update([
                'estado_evidencia_pago_id' => EstadoEvidenciaPago::id(
                    EstadoEvidenciaPago::RECHAZADO
                ),
                'slin_respuesta' => 'Error de comunicación con SLIN',
                'usuario_valida_id' => auth()->id(),
            ]);

            $this->dispatch('alertaLivewire', [
                'title' => 'Error',
                'text' => 'Error de comunicación con SLIN',
            ]);

            return;
        }

        if (
            isset($body['data']['success']) &&
            $body['data']['success'] === false
        ) {
            $this->evidencia->update([
                'estado_evidencia_pago_id' => EstadoEvidenciaPago::id(
                    EstadoEvidenciaPago::OBSERVADO
                ),
                'slin_respuesta' => $body['data']['message'] ?? 'Error en SLIN',
                'usuario_valida_id' => auth()->id(),
            ]);

            $this->dispatch('alertaLivewire', [
                'title' => 'Advertencia',
                'text' => $body['data']['message'] ?? 'Error en SLIN',
            ]);

            return;
        }

        $this->evidencia->update([
            'estado_evidencia_pago_id' => EstadoEvidenciaPago::id(
                EstadoEvidenciaPago::APROBADO
            ),
            'slin_respuesta' => $body['data']['message'],
            'usuario_valida_id' => auth()->id(),
        ]);

        $this->dispatch('alertaLivewire', [
            'title' => 'Enviado',
            'text' => 'Se envió correctamente.',
        ]);
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
