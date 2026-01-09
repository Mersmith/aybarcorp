<?php

namespace App\Livewire\Admin\ClienteAntiguo;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Throwable;

#[Layout('layouts.admin.layout-admin')]
class ClienteAntiguoCrearLivewire extends Component
{
    public $dni = '';
    public $informaciones;

    public $razon_social = '';
    public $proyecto = '';
    public $etapa = '';
    public $lote = '';
    public $nombre = '';
    public $codigo = '';

    public function mount()
    {
        $this->informaciones = collect();
    }

    public function buscarCliente()
    {
        $this->resetAntesDeBuscar();

        try {
            $this->validate([
                'dni' => 'required',
            ]);
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->informaciones = DB::table('clientes_2')
            ->where('dni', $this->dni)
            ->get();

        if ($this->informaciones->isEmpty()) {
            session()->flash('error', 'No se encontró información para el DNI/RUC ingresado.');
        } else {
            session()->flash(
                'success',
                'Cliente encontrado en DB Antiguo'
            );
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
            DB::table('clientes_2')->insert([
                'razon_social' => $this->razon_social,
                'codigo_cliente' => $this->codigo,
                'nombre' => $this->nombre,
                'codigo_proyecto' => null,
                'proyecto' => $this->proyecto,
                'etapa' => $this->etapa,
                'numero_lote' => $this->lote,
                'estado_lote' => null,
                'dni' => $this->dni,
            ]);

            $this->informaciones = DB::table('clientes_2')
                ->where('dni', $this->dni)
                ->get();

            $this->dispatch('alertaLivewire', [
                'title' => 'Creado',
                'text' => 'Se guardó el registro correctamente.',
                'showConfirmButton' => true,
            ]);

        } catch (Throwable $e) {
            report($e);
            $this->dispatch('alertaLivewire', ['title' => 'Error', 'text' => 'Ocurrió un problema al procesar la solicitud.']);
        }
    }

    public function resetAntesDeBuscar()
    {
        $this->reset([
            'informaciones',
            'razon_social',
            'proyecto',
            'etapa',
            'lote',
            'nombre',
            'codigo',
        ]);

        $this->resetValidation();
        session()->forget(['success', 'error', 'info']);
    }

    public function render()
    {
        return view('livewire.admin.cliente-antiguo.cliente-antiguo-crear-livewire');
    }
}
