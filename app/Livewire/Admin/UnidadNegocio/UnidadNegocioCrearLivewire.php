<?php

namespace App\Livewire\Admin\UnidadNegocio;

use App\Models\UnidadNegocio;
use Illuminate\Validation\ValidationException;
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
            'nombre' => 'required|unique:unidad_negocios,nombre',
            'razon_social' => 'required|string|max:255',
        ];
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        UnidadNegocio::create([
            'nombre' => $this->nombre,
            'razon_social' => $this->razon_social,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Creado', 'text' => 'Se guardó correctamente.']);

        return redirect()->route('admin.unidad-negocio.vista.todo');
    }

    public function render()
    {
        return view('livewire.admin.unidad-negocio.unidad-negocio-crear-livewire');
    }
}
