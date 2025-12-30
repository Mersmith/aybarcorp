<?php

namespace App\Livewire\Cliente\Lote;

use App\Services\SlinService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class LoteTodoLivewire extends Component
{
    public $cliente_encontrado = null;

    public $razones_sociales = [];
    public $razon_social_id = "";
    public $razon_social_select;

    public $lotes = null;
    public $lote_select = null;

    public $cronograma = [];
    public $estado_cuenta = [];

    public ?string $vista = null; // 'cronograma' | 'estado_cuenta'

    public function mount(SlinService $slinService)
    {
        $dni = Auth::user()->cliente->dni;

        $cliente = Http::get("https://aybarcorp.com/slin/cliente/{$dni}")->json();

        if (empty($cliente)) {
            session()->flash('error', 'Inténtelo más tarde, por favor.');
            return;
        }

        $this->cliente_encontrado = $cliente;
        $this->razones_sociales = $cliente['empresas'] ?? [];
    }

    public function updatedRazonSocialId($value, SlinService $slinService)
    {
        if (empty($value)) {
            $this->razon_social_select = null;
            $this->lotes = null;
            return;
        }

        $this->razon_social_select = collect($this->razones_sociales)
            ->firstWhere('id_empresa', $value);

        if (!$this->razon_social_select) {
            $this->lotes = null;
            return;
        }

        $params = [
            'id_cliente' => $this->razon_social_select['codigo'],
            'id_empresa' => $this->razon_social_select['id_empresa'],
        ];

        $response = Http::get('https://aybarcorp.com/slin/lotes', $params);

        if (!$response->successful()) {
            $this->lotes = [];
            session()->flash('error', 'Inténtelo más tarde, por favor.');
            return;
        }

        $lotesResponse = $response->json();
        if (isset($lotesResponse['data']) && is_array($lotesResponse['data'])) {
            $this->lotes = $lotesResponse['data'];
        } elseif (is_array($lotesResponse)) {
            $this->lotes = $lotesResponse;
        } else {
            $this->lotes = [];
        }

        $this->lote_select = null;
    }

    public function verCronograma(array $lote, SlinService $slinService)
    {
        $this->lote_select = $lote;
        $this->vista = 'cronograma';

        $params = [
            'empresa' => $this->lote_select['id_empresa'],
            'lote' => $this->lote_select['id_proyecto'] . '' . $this->lote_select['id_etapa'] . '-' . $this->lote_select['id_manzana'] . '-' . $this->lote_select['id_lote'],
            'cliente' => $this->lote_select['id_cliente'],
            'contrato' => $this->lote_select['contrato'] ?? '',
            'servicio' => $this->lote_select['servicio'] ?? '02',
        ];

        $response = Http::get('https://aybarcorp.com/slin/cuotas', $params);
        $cronograma = $response->successful() ? $response->json() : null;

        if (empty($cronograma)) {
            $this->cronograma = [];
            session()->flash('error', 'Inténtelo más tarde, por favor.');
            return;
        }

        $this->cronograma = $cronograma;
    }

    public function verEstadoCuenta(array $lote, SlinService $slinService)
    {
        $this->lote_select = $lote;
        $this->vista = 'estado_cuenta';

        $params = [
            'empresa' => $this->lote_select['id_empresa'],
            'lote' => $this->lote_select['id_proyecto'] . '' . $this->lote_select['id_etapa'] . '-' . $this->lote_select['id_manzana'] . '-' . $this->lote_select['id_lote'],
            'cliente' => $this->lote_select['id_cliente'],
            'contrato' => $this->lote_select['contrato'] ?? '',
            'servicio' => $this->lote_select['servicio'] ?? '02',
        ];

        $response = Http::get('https://aybarcorp.com/slin/estado-cuenta', $params);
        $estado_cuenta = $response->successful() ? $response->json() : null;

        if (empty($estado_cuenta)) {
            $this->estado_cuenta = [];
            session()->flash('error', 'Inténtelo más tarde, por favor.');
            return;
        }

        $this->estado_cuenta = $estado_cuenta;
    }

    public function cerrarVista()
    {
        $this->lote_select = null;
        $this->cronograma = [];
        $this->estado_cuenta = [];
        $this->vista = null;
    }

    public function descargarPDFcronograma()
    {
        if (!$this->lote_select || empty($this->cronograma)) {
            session()->flash('error', 'Debe seleccionar un lote antes de descargar.');
            return;
        }

        $total_pagados = collect($this->cronograma)
            ->where('estado', 'PAGADO')
            ->count();

        $pdf = Pdf::loadView('pdf.cronograma', [
            'lote' => $this->lote_select,
            'cronograma' => $this->cronograma,
            'total_pagados' => $total_pagados,
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'cronograma-' . $this->lote_select['id_recaudo'] . '.pdf'
        );
    }

    public function descargarPDFestadoCuenta()
    {
        if (!$this->lote_select || empty($this->estado_cuenta)) {
            session()->flash('error', 'Debe seleccionar un lote antes de descargar.');
            return;
        }

        $pdf = Pdf::loadView('pdf.estado-cuenta', [
            'estado_cuenta' => $this->estado_cuenta,
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'estado-cuenta-' . $this->lote_select['id_recaudo'] . '.pdf'
        );
    }

    public function render()
    {
        return view('livewire.cliente.lote.lote-todo-livewire');
    }
}
