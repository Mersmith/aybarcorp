<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class ComprobanteController extends Controller
{
    public function ver(Request $request)
    {
        $params = [
            'empresa' => '019',
            'comprobante' => '01-FF01-00000002',
        ];

        $response = Http::get('https://aybarcorp.com/slin/comprobante', $params);

        if ($response->failed()) {
            abort(404, 'No se pudo obtener el comprobante');
        }

        $json = $response->json();

        if (empty($json['base64'])) {
            abort(500, 'Comprobante inválido');
        }

        $pdfBinary = base64_decode($json['base64']);

        return response($pdfBinary)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="comprobante.pdf"');
    }
}
