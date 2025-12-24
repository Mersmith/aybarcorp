<?php

namespace App\Livewire\Admin\UnidadNegocio;

use App\Models\UnidadNegocio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

#[Layout('layouts.admin.layout-admin')]
class UnidadNegocioEditarLivewire extends Component
{
    public $unidad_negocio;

    public $nombre;
    public $razon_social;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
        ];
    }

    public function mount($id)
    {
        $this->unidad_negocio = UnidadNegocio::findOrFail($id);

        $this->nombre  = $this->unidad_negocio->nombre ;
        $this->razon_social = $this->unidad_negocio->razon_social;
    }

    public function store()
    {
        $this->validate();

        $this->unidad_negocio->update([
            'nombre' => $this->nombre,
            'razon_social' => $this->razon_social,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    #[On('eliminarUnidadNegocioOn')]
    public function eliminarUnidadNegocioOn()
    {
        if ($this->unidad_negocio) {
            $this->unidad_negocio->delete();

            return redirect()->route('admin.unidad-negocio.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.admin.unidad-negocio.unidad-negocio-editar-livewire');
    }
}
