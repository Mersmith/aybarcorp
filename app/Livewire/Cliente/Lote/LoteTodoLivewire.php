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
        $lotes = $response->successful() ? $response->json() : null;

        if (empty($lotes)) {
            $this->lotes = [];
            session()->flash('error', 'Inténtelo más tarde, por favor.');
            return;
        }

        $this->lotes = $lotes;

        $this->lote_select = null;
    }

    public function seleccionarLote(array $lote, SlinService $slinService)
    {
        $this->lote_select = $lote;

        $params = [
            'id_empresa' => $this->lote_select['id_empresa'],
            'id_cliente' => $this->lote_select['id_cliente'],
            'id_proyecto' => $this->lote_select['id_proyecto'],
            'id_etapa' => $this->lote_select['id_etapa'],
            'id_manzana' => $this->lote_select['id_manzana'],
            'id_lote' => $this->lote_select['id_lote'],
        ];

        $response = Http::get('https://aybarcorp.com/slin/cuotas', $params);
        $cronograma = $response->successful() ? $response->json() : null;

        if (empty($cronograma)) {
            $this->cronograma = [];
            session()->flash('error', 'Inténtelo más tarde, por favor.');
            return;
        }

        $this->cronograma = collect($cronograma)
            ->map(function ($item) {
                return [
                     ...$item,
                    'estado' => match ($item['estado']) {
                        'PG PAGADA' => 'PAGADO',
                        'CR CARTERA' => 'PENDIENTE',
                        default => 'OBSERVACIÓN',
                    },
                ];
            })
            ->toArray();
    }

    public function cerrarCronograma()
    {
        $this->lote_select = null;
        //$this->cronograma = [];
    }

    public function descargarPDF()
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

    public function render()
    {
        return view('livewire.cliente.lote.lote-todo-livewire');
    }
}
