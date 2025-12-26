<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SlinController extends Controller
{
    private $baseUrl = "https://cloudapp.slin.com.pe:7444/activity/v1/api/aybar";
    private $user = "api_slin_aybar";
    private $password = "S!lin_AyB@r2025#SecureX";

    private $remoteBase = "https://aybarcorp.com/slin";

    /**
     * 1. CLIENTES
     * GET /slin/cliente/{dni}
     */
    public function getCliente($dni)
    {
        $response = Http::withBasicAuth($this->user, $this->password)
            ->get("{$this->baseUrl}/clientes/nit/{$dni}");

        if ($response->failed()) {
            return response()->json([
                'error' => true,
                'message' => 'Error consultando cliente',
                'details' => $response->body(),
            ], 500);
        }

        return $response->json();
    }

    /**
     * 2. LOTES
     * GET /slin/lotes?id_cliente=C00896&id_empresa=019
     */
    public function getLotes(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required',
            'id_empresa' => 'required',
        ]);

        $response = Http::withBasicAuth($this->user, $this->password)
            ->get("{$this->baseUrl}/lotes", [
                'id_cliente' => $request->id_cliente,
                'id_empresa' => $request->id_empresa,
            ]);

        if ($response->failed()) {
            return response()->json([
                'error' => true,
                'message' => 'Error consultando lotes',
                'details' => $response->body(),
            ], 500);
        }

        return $response->json();
    }

    /**
     * 3. CUOTAS
     * GET /slin/cuotas?id_empresa=019&id_cliente=C00896&id_proyecto=005&id_etapa=01&id_manzana=F&id_lote=28.R
     */
    public function getCuotas(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required',
            'id_cliente' => 'required',
            'id_proyecto' => 'required',
            'id_etapa' => 'required',
            'id_manzana' => 'required',
            'id_lote' => 'required',
        ]);

        $response = Http::withBasicAuth($this->user, $this->password)
            ->get("{$this->baseUrl}/cuotas", $request->all());

        if ($response->failed()) {
            return response()->json([
                'error' => true,
                'message' => 'Error consultando cuotas',
                'details' => $response->body(),
            ], 500);
        }

        return $response->json();
    }

    public function probarCliente()
    {
        $dni = "41870082";

        $response = Http::get("{$this->remoteBase}/cliente/{$dni}");

        return $response->json();
    }

    public function probarLotes()
    {
        $params = [
            "id_cliente" => "C00896",
            "id_empresa" => "019",
        ];

        $response = Http::get("{$this->remoteBase}/lotes", $params);

        return $response->json();
    }

    public function probarCuotas()
    {
        $params = [
            "id_empresa" => "019",
            "id_cliente" => "C00896",
            "id_proyecto" => "005",
            "id_etapa" => "01",
            "id_manzana" => "F",
            "id_lote" => "28.R",
        ];

        $response = Http::get("{$this->remoteBase}/cuotas", $params);

        return $response->json();
    }

    public function probarEstadoCuenta()
    {
        /*$params = [
            'empresa' => '014',
            'lote' => '00101-A-0001', //proyecto/etapa-manza-lote
            'cliente' => 'C10838',
            'contrato' => '', //opcional//si es null, porque fue migrado
            'servicio' => '02', //default, solo para cuotas
        ];*/

        $params = [
            'empresa' => '019',
            'lote' => '00501-F-28.R', //proyecto/etapa-manza-lote
            'cliente' => 'C00896',
            'contrato' => '', //opcional//si es null, porque fue migrado
            'servicio' => '02', //default, solo para cuotas
        ];

        $response = Http::acceptJson()
            ->get("{$this->remoteBase}/estado-cuenta", $params);

        if ($response->failed()) {
            return response()->json([
                'status' => $response->status(),
                'error' => $response->body(),
            ]);
        }

        return response()->json([
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }

    public function probarComprobante()
    {
        $params = [
            'empresa' => '019',
            'comprobante' => '01-FF01-00000002',
        ];

        $response = Http::acceptJson()
            ->get("{$this->remoteBase}/comprobante", $params);

        if ($response->failed()) {
            return response()->json([
                'status' => $response->status(),
                'error' => $response->body(),
            ]);
        }

        return response()->json([
            'status' => $response->status(),
            'data' => $response->json(),
        ]);
    }
}
