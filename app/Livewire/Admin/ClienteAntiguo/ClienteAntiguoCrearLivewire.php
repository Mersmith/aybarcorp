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

    public function render()
    {
        return view('livewire.admin.cliente-antiguo.cliente-antiguo-crear-livewire');
    }
}
