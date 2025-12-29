<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class ComprobanteController extends Controller
{
    public function ver(Request $request)
    {
        $empresa = $request->query('empresa');
        $comprobante = $request->query('comprobante');

        if (!$empresa || !$comprobante) {
            abort(400, 'Parámetros inválidos');
        }

        $response = Http::get('https://aybarcorp.com/slin/comprobante', [
            'empresa' => $empresa,
            'comprobante' => $comprobante,
        ]);

        if ($response->failed()) {
            abort(404, 'No se pudo obtener el comprobante');
        }

        $json = $response->json();

        if (empty($json['base64'])) {
            abort(500, 'Comprobante inválido');
        }

        $pdfBinary = base64_decode($json['base64']);

        return response($pdfBinary, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="comprobante.pdf"');
    }
}
