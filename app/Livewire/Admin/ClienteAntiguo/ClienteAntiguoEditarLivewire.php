<?php

namespace App\Livewire\Admin\ClienteAntiguo;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Throwable;

#[Layout('layouts.admin.layout-admin')]
class ClienteAntiguoEditarLivewire extends Component
{
    public $registro;
    public $informaciones;

    public $dni = '';
    public $razon_social = '';
    public $proyecto = '';
    public $etapa = '';
    public $lote = '';
    public $nombre = '';
    public $codigo = '';

    public function mount($id)
    {
        $this->registro = DB::table('clientes_2')
            ->where('id', $id)
            ->first();

        if (!$this->registro) {
            abort(404);
        }

        $this->dni = $this->registro->dni;
        $this->razon_social = $this->registro->razon_social;
        $this->proyecto = $this->registro->proyecto;
        $this->etapa = $this->registro->etapa;
        $this->lote = $this->registro->numero_lote;
        $this->nombre = $this->registro->nombre;
        $this->codigo = $this->registro->codigo_cliente;

        $this->informaciones = DB::table('clientes_2')
            ->whereNotNull('dni')
            ->where('dni', '!=', '')
            ->where('dni', $this->dni)
            ->get();

        if ($this->informaciones->isEmpty()) {
            session()->flash('error', 'No se encontró información para el DNI/RUC ingresado.');
        } else {
            session()->flash('success', 'Cliente encontrado en DB Antiguo');
        }
    }

    public function store()
    {
        try {
            $this->validate([
                'dni' => 'required',
                'razon_social' => 'required',
                'proyecto' => 'required',
                'etapa' => 'required',
                'lote' => 'required',
                'nombre' => 'required',
                'codigo' => 'required',
            ]);
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        try {
            DB::table('clientes_2')
                ->where('id', $this->registro->id)
                ->update([
                    'razon_social' => $this->razon_social,
                    'codigo_cliente' => $this->codigo,
                    'nombre' => $this->nombre,
                    'proyecto' => $this->proyecto,
                    'etapa' => $this->etapa,
                    'numero_lote' => $this->lote,
                    'dni' => $this->dni,
                ]);

            $this->registro = DB::table('clientes_2')
                ->where('id', $this->registro->id)
                ->first();

            $this->informaciones = DB::table('clientes_2')
                ->where('dni', $this->dni)
                ->get();

            $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);

        } catch (Throwable $e) {
            report($e);
            $this->dispatch('alertaLivewire', ['title' => 'Error', 'text' => 'Ocurrió un problema al procesar la solicitud.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.cliente-antiguo.cliente-antiguo-editar-livewire');
    }
}
