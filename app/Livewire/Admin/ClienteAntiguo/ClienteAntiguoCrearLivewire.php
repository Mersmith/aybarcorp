<?php

namespace App\Livewire\Admin\ClienteAntiguo;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class ClienteAntiguoCrearLivewire extends Component
{
    public $dni;
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
        $this->validate([
            'dni' => 'required',
        ]);

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
        $this->validate([
            'dni' => 'required',
            'razon_social' => 'required',
            'proyecto' => 'required',
            'etapa' => 'required',
            'lote' => 'required',
            'nombre' => 'required',
            'codigo' => 'required',
        ]);

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
                'dni' => $this->dni, // IMPORTANTE si estás buscando por dni
            ]);

            // 🔄 refrescar informaciones
            $this->informaciones = DB::table('clientes_2')
                ->where('dni', $this->dni)
                ->get();

            $this->dispatch('alertaLivewire', 'Creado');

        } catch (\Throwable $e) {
            report($e);
            $this->dispatch('alertaLivewire', 'Error');
        }
    }

    public function render()
    {
        return view('livewire.admin.cliente-antiguo.cliente-antiguo-crear-livewire');
    }
}
