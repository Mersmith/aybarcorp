<?php

namespace App\Livewire\Admin\UnidadNegocio;

use App\Models\UnidadNegocio;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class UnidadNegocioCrearLivewire extends Component
{
    public $nombre;
    public $razon_social;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
        ];
    }

    public function store()
    {
        $this->validate();

        UnidadNegocio::create([
            'nombre' => $this->nombre,
            'razon_social' => $this->razon_social,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.unidad-negocio.vista.todo');
    }

    public function render()
    {
        return view('livewire.admin.unidad-negocio.unidad-negocio-crear-livewire');
    }
}
