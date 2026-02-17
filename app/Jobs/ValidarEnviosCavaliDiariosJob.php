<?php

namespace App\Jobs;

use App\Models\SolicitudDigitalizarLetra;
use App\Services\CavaliService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ValidarEnviosCavaliDiariosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(CavaliService $service): void
    {
        Log::channel('cavali')->info('JOB VALIDAR: Iniciando validación de envíos');

        $solicitudes = SolicitudDigitalizarLetra::where('estado_cavali', 'enviado')->get();

        if ($solicitudes->isEmpty()) {
            Log::channel('cavali')->info('JOB VALIDAR: No hay solicitudes para validar');
            return;
        }

        foreach ($solicitudes as $solicitud) {
            try {
                // nroCavali = codigo_cuota + numero_cuota
                $nroCavali = ($solicitud->codigo_cuota ?? '') . ($solicitud->numero_cuota ?? '');

                if (empty($nroCavali)) {
                    Log::channel('cavali')->warning('JOB VALIDAR: Solicitud sin nroCavali', [
                        'id' => $solicitud->id,
                        'codigo_venta' => $solicitud->codigo_venta
                    ]);
                    continue;
                }

                $result = $service->obtenerConstanciaCancelacion($nroCavali);

                // '001' es el código de éxito según el servicio Cavali/Canvia
                if (($result['codigo'] ?? '') === '001' && !empty($result['base64'])) {
                    $solicitud->update(['estado_cavali' => 'validado']);
                    Log::channel('cavali')->info('JOB VALIDAR: Solicitud validada correctamente', [
                        'id' => $solicitud->id,
                        'nroCavali' => $nroCavali
                    ]);
                } else {
                    $solicitud->update(['estado_cavali' => 'observado']);
                    Log::channel('cavali')->warning('JOB VALIDAR: Solicitud observada (Constancia no encontrada)', [
                        'id' => $solicitud->id,
                        'nroCavali' => $nroCavali,
                        'codigo_respuesta' => $result['codigo'] ?? 'N/A'
                    ]);
                }
            } catch (\Exception $e) {
                Log::channel('cavali')->error('JOB VALIDAR: Error al validar solicitud', [
                    'id' => $solicitud->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        Log::channel('cavali')->info('JOB VALIDAR: Proceso finalizado');
    }
}
