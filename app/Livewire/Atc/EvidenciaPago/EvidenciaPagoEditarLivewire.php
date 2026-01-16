<?php

namespace App\Livewire\Atc\EvidenciaPago;

use App\Mail\EvidenciaPagoObservacionMail;
use App\Models\CorreoEvidenciaPago;
use App\Models\EstadoEvidenciaPago;
use App\Models\Proyecto;
use App\Models\SolicitudEvidenciaPago;
use App\Models\UnidadNegocio;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
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
    public $solicitud;
    public $estados, $estado_id = '';

    public $mensaje;

    public $empresas, $unidad_negocio_id = '';
    public $proyectos = [], $proyecto_id = '';

    public $gestores, $gestor_id = '';

    public $evidenciaSeleccionada;
    public $evidenciaSeleccionadaId = null;

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
        $this->solicitud = SolicitudEvidenciaPago::findOrFail($id);

        $this->estado_id = $this->solicitud->estado_evidencia_pago_id;
        $this->unidad_negocio_id = $this->solicitud->unidad_negocio_id;
        $this->proyecto_id = $this->solicitud->proyecto_id;
        $this->gestor_id = $this->solicitud->gestor_id ?? '';

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

        $this->solicitud->update([
            'unidad_negocio_id' => $this->unidad_negocio_id,
            'proyecto_id' => $this->proyecto_id,
            'gestor_id' => $this->gestor_id,
            'estado_evidencia_pago_id' => $this->estado_id,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    public function enviarSlin()
    {
        if (
            $this->solicitud->slin_asbanc === false
        ) {
            $this->dispatch('alertaLivewire', [
                'title' => 'Error',
                'text' => 'No es Asbanc o ya tiene evidencia',
            ]);
            return;
        }

        if ($this->solicitud->slin_monto == $this->evidenciaSeleccionada->monto && $this->solicitud->slin_numero_operacion == $this->evidenciaSeleccionada->numero_operacion) {
            $this->dispatch('alertaLivewire', [
                'title' => 'Error',
                'text' => 'No coincide el monto o el número de operación',
            ]);
            return;
        }

        if (!Storage::disk('public')->exists($this->evidenciaSeleccionada->path)) {
            $this->dispatch('alertaLivewire', 'Error');
            return;
        }

        $imageContent = Storage::disk('public')->get($this->evidenciaSeleccionada->path);

        $params = [
            'lote' => (string) $this->solicitud->lote_completo,
            'cliente' => (string) $this->solicitud->codigo_cliente,
            'contrato' => '', // nullable|string → enviar vacío
            'idcobranzas' => (string) $this->solicitud->transaccion_id,
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
            $estadoRechazadoId = EstadoEvidenciaPago::id(
                EstadoEvidenciaPago::RECHAZADO
            );

            $this->solicitud->update([
                'estado_evidencia_pago_id' => $estadoRechazadoId,
                'usuario_valida_id' => auth()->id(),
            ]);

            $this->evidenciaSeleccionada->update([
                'estado_evidencia_pago_id' => $estadoRechazadoId,
                'slin_respuesta' => $body['data']['message'] ?? 'Error en SLIN',
            ]);

            $this->estado_id = $estadoRechazadoId;
            $this->dispatch('alertaLivewire', [
                'title' => 'Advertencia',
                'text' => $body['data']['message'] ?? 'Error en SLIN',
            ]);

            return;
        }

        $estadoAprobadoId = EstadoEvidenciaPago::id(
            EstadoEvidenciaPago::APROBADO
        );

        $this->solicitud->update([
            'estado_evidencia_pago_id' => $estadoAprobadoId,
            'slin_evidencia' => true,
            'usuario_valida_id' => auth()->id(),
            'fecha_validacion' => now(),
        ]);

        $this->evidenciaSeleccionada->update([
            'estado_evidencia_pago_id' => $estadoAprobadoId,
            'slin_respuesta' => $body['data']['message'] ?? 'Error en SLIN',
        ]);

        $this->estado_id = $estadoAprobadoId;
        $this->solicitud->refresh();
        $this->evidenciaSeleccionada->refresh();
        $this->dispatch('alertaLivewire', [
            'title' => 'Enviado',
            'text' => 'Se envió correctamente.',
        ]);
    }

    public function seleccionarEvidencia($evidenciaId)
    {
        $this->evidenciaSeleccionada =
            $this->solicitud->evidencias->firstWhere('id', $evidenciaId);

        $this->evidenciaSeleccionadaId = $evidenciaId;

        if ($this->solicitud->slin_monto == $this->evidenciaSeleccionada->monto) {
            session()->flash('success', 'Coincide el monto');
        } else {
            session()->flash('info', 'No concide el monto');
        }
    }

    public function enviarCorreo()
    {
        $emailDestino = $this->solicitud->userCliente->email ?? null;

        try {
            $this->validate([
                'mensaje' => 'required|string',
                'gestor_id' => 'required',
            ]);
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', [
                'title' => 'Advertencia',
                'text' => 'Verifique los errores de los campos resaltados.',
            ]);
            throw $e;
        }

        if (!$emailDestino || !filter_var($emailDestino, FILTER_VALIDATE_EMAIL)) {
            $this->dispatch('alertaLivewire', [
                'title' => 'Advertencia',
                'text' => 'El cliente no tiene un correo válido.',
            ]);
            return;
        }

        DB::transaction(function () use ($emailDestino) {

            Mail::to($emailDestino)
                ->send(new EvidenciaPagoObservacionMail(
                    $emailDestino,
                    $this->solicitud,
                    $this->mensaje
                ));

            CorreoEvidenciaPago::create([
                'solicitud_evidencia_pago_id' => $this->solicitud->id,
                'mensaje' => $this->mensaje,
                'enviado_at' => now(),
            ]);
        });

        $this->mensaje = null;

        $this->dispatch('alertaLivewire', [
            'title' => 'Enviado',
            'text' => 'El correo fue enviado y registrado correctamente.',
        ]);
    }

    public function render()
    {
        return view('livewire.atc.evidencia-pago.evidencia-pago-editar-livewire');
    }
}
