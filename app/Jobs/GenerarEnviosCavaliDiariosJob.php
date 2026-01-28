<?php

namespace App\Jobs;

use App\Models\EnvioCavali;
use App\Models\SolicitudDigitalizarLetra;
use App\Models\UnidadNegocio;
use App\Exports\CavaliExport;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class GenerarEnviosCavaliDiariosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $fecha = now()->toDateString();

        UnidadNegocio::query()->each(function ($unidad) use ($fecha) {

            $solicitudes = SolicitudDigitalizarLetra::where('unidad_negocio_id', $unidad->id)
                ->where('estado_cavali', 'pendiente')
                ->get();

            if ($solicitudes->isEmpty()) {
                return;
            }

            // Evita duplicar cortes
            $envio = EnvioCavali::firstOrCreate(
                [
                    'fecha_corte' => $fecha,
                    'unidad_negocio_id' => $unidad->id,
                ],
                [
                    'estado' => 'pendiente',
                ]
            );

            $result = $envio->solicitudes()->syncWithoutDetaching(
                $solicitudes->pluck('id')
            );

            \Log::info('JOB CAVALI: sync ejecutado', [
                'envio_id' => $envio->id,
                'attached' => $result['attached'] ?? [],
            ]);

            // Nombre del archivo
            $fileName = "CAVALI_{$unidad->razon_social}_{$fecha}.xlsx";
            $path = "cavali/{$fecha}/{$fileName}";

            // Generar Excel
            Excel::store(
                new CavaliExport($envio),
                $path,
                'local'
            );

            \Log::info('JOB CAVALI: excel generado', [
                'path' => storage_path('app/' . $path),
                'exists' => \Storage::disk('local')->exists($path),
            ]);
            /*

            // Actualizar envío
            $envio->update([
                'estado' => 'enviado',
                'enviado_at' => now(),
                'archivo_zip' => $path,
            ]);

            // Actualizar solicitudes
            SolicitudDigitalizarLetra::whereIn('id', $solicitudes->pluck('id'))
                ->update(['estado_cavali' => 'enviado']);

            // Enviar correo
            Mail::raw(
                "Se adjunta el envío CAVALI del {$fecha} ({$unidad->razon_social})",
                function ($message) use ($path, $fileName) {
                    $message->to('PROGRAMADOR@aybarsac.com')
                        ->subject('Envío CAVALI Diario')
                        ->attach(Storage::path($path), [
                            'as' => $fileName,
                        ]);
                }
            );*/
        });
    }
}
