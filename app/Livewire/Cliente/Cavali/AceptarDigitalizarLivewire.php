<?php

namespace App\Livewire\Cliente\Cavali;

use Livewire\Component;
use App\Models\SolicitudDigitalizarLetra;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AceptarDigitalizarLivewire extends Component
{
    public $lote;
    public $cuota;

    public function mount($cuota, $lote)
    {
        $this->cuota = $cuota;
        $this->lote = $lote;
    }

    public function guardar()
    {
        DB::transaction(function () {
            SolicitudDigitalizarLetra::firstOrCreate(
                [
                    'codigo_cuota' => $this->cuota["idCuota"] ?? null,
                ],
                [
                    'unidad_negocio_id' => 1,
                    'proyecto_id' => 1,
                    'cliente_id' => Auth::id(),

                    'razon_social' => $this->lote["razon_social"] ?? null,
                    'nombre_proyecto' => $this->lote["descripcion"] ?? null,
                    'etapa' => $this->lote["id_etapa"] ?? null,
                    'manzana' => $this->lote["id_manzana"] ?? null,
                    'lote' => $this->lote["id_lote"] ?? null,
                    'codigo_cliente' => $this->lote["id_cliente"] ?? null,
                    'numero_cuota' => $this->cuota["NroCuota"] ?? null,
                    'codigo_venta' => $this->lote["id_recaudo"] ?? null,
                    'fecha_vencimiento' => $this->cuota["FecVencimiento"] ?? null,
                    'importe_cuota' => $this->cuota["Cuota"] ?? null,

                    'lote_completo' =>
                    $this->lote['id_proyecto'] .
                        $this->lote['id_etapa'] . '-' .
                        $this->lote['id_manzana'] . '-' .
                        $this->lote['id_lote'],
                ]
            );
        });
        session()->flash('success', 'Solicitud enviado correctamente.');
        $this->dispatch('actualizarCronograma');
    }

    public function render()
    {
        return view('livewire.cliente.cavali.aceptar-digitalizar-livewire');
    }
}
