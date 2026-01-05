<?php

namespace App\Http\Controllers;

use App\Services\CanviaSoapService;

class ConstanciaController extends Controller
{
    public function obtener($numeroLetra, CanviaSoapService $service)
    {
        if (strlen($numeroLetra) !== 12) {
            return response()->json([
                'error' => 'NumeroLetra debe tener exactamente 12 caracteres'
            ], 422);
        }

        $result = $service->obtenerConstanciaCancelacion($numeroLetra);

        if ($result['codigo'] !== '001' || empty($result['base64'])) {
            return response()->json([
                'error' => 'Servicio SOAP respondió con error'
            ], 400);
        }

        $pdf = base64_decode($result['base64']);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="constancia.pdf"',
        ]);
    }
}
