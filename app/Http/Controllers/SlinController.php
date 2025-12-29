<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SlinController extends Controller
{
    private string $baseUrl;
    private string $baseUrlEstadoCuenta;
    private string $baseUrlComprobante;
    private string $remoteBase;
    private string $user;
    private string $password;

    public function __construct()
    {
        $this->baseUrl = 'https://cloudapp.slin.com.pe:7444/activity/v1/api/aybar';
        $this->baseUrlEstadoCuenta = 'https://cloudapp.slin.com.pe:7444/activity/api/v1/aybarweb/cronograma';
        $this->baseUrlComprobante = 'https://prod.slin-ade.pe:8443/Utilidades/api/v1/aybarcorp/GetComprobantesBase64';
        $this->remoteBase = 'https://aybarcorp.com/slin';

        $this->user = config('services.slin.user');
        $this->password = config('services.slin.password');
    }

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

    public function getEstadoCuenta(Request $request)
    {
        $request->validate([
            'empresa'  => 'required|string',
            'lote'     => 'required|string',
            'cliente'  => 'required|string',
            'contrato' => 'nullable|string',
            'servicio' => 'required|string',
        ]);

        $params = [
            'empresa'  => $request->empresa,
            'lote'     => $request->lote,
            'cliente'  => $request->cliente,
            'contrato' => $request->contrato ?? '',
            'servicio' => $request->servicio,
        ];

        $response = Http::withBasicAuth($this->user, $this->password)
            ->acceptJson()
            ->timeout(15)
            ->get($this->baseUrlEstadoCuenta, $params);

        if ($response->failed()) {
            return response()->json([
                'error'  => true,
                'status' => $response->status(),
                'detail' => $response->body(),
            ], 502);
        }

        return response()->json($response->json());
    }

    public function getComprobante(Request $request)
    {
        $data = $request->validate([
            'empresa'     => 'required|string',
            'comprobante' => 'required|string',
        ]);

        try {
            $url = sprintf(
                '%s/%s/%s',
                $this->baseUrlComprobante,
                $data['empresa'],
                $data['comprobante']
            );

            $response = Http::withBasicAuth($this->user, $this->password)
                ->acceptJson()
                ->timeout(20)
                ->get($url);

            if ($response->failed()) {
                return response()->json([
                    'error'   => true,
                    'message' => 'Error consultando comprobante en SLIN',
                    'status'  => $response->status(),
                    'details' => $response->body(),
                ], 502);
            }

            return response()->json($response->json());
        } catch (\Throwable $e) {
            \Log::error('SLIN GetComprobante error', [
                'exception' => $e->getMessage(),
            ]);

            return response()->json([
                'error'   => true,
                'message' => 'Error interno del servidor',
            ], 500);
        }
    }

    public function probarCliente()
    {
        //$dni = "41870082";
        //$dni = "71962580";
        //$dni = "71962580";
        $dni = "47231144";

        $response = Http::get("{$this->remoteBase}/cliente/{$dni}");

        return $response->json();
    }

    public function probarLotes()
    {
        $params = [
            "id_cliente" => "C00896",
            "id_empresa" => "019",
        ];

        /*$params = [
            "id_cliente" => "C18465",
            "id_empresa" => "014",
        ];*/

        /*$params = [
            "id_cliente" => "C10838",
            "id_empresa" => "014",
        ];*/

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
        $params = [
            'empresa' => '014',
            'lote' => '00101-A-0001', //proyecto/etapa-manza-lote
            'cliente' => 'C10838',
            'contrato' => '', //opcional//si es null, porque fue migrado
            'servicio' => '02', //default, solo para cuotas
        ];

        /*$params = [
            'empresa' => '019',
            'lote' => '00501-F-28.R', //proyecto/etapa-manza-lote
            'cliente' => 'C00896',
            'contrato' => '', //opcional//si es null, porque fue migrado
            'servicio' => '02', //default, solo para cuotas
        ];*/

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

        /*$params = [
            'empresa' => '019',
            'comprobante' => '01-B0024-',
        ];*/

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
