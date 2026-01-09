<?php

namespace App\Livewire\Admin\UnidadNegocio;

use App\Models\UnidadNegocio;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class UnidadNegocioEditarLivewire extends Component
{
    public $unidad_negocio;

    public $nombre;
    public $razon_social;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:unidad_negocios,nombre,' . $this->unidad_negocio->id,
            'razon_social' => 'required|string|max:255',
        ];
    }

    public function mount($id)
    {
        $this->unidad_negocio = UnidadNegocio::findOrFail($id);

        $this->nombre = $this->unidad_negocio->nombre;
        $this->razon_social = $this->unidad_negocio->razon_social;
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->unidad_negocio->update([
            'nombre' => $this->nombre,
            'razon_social' => $this->razon_social,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
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
