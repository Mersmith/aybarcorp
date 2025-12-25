<?php

namespace App\Livewire\Admin\Sede;

use App\Models\Sede;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class SedeEditarLivewire extends Component
{
    public $sede;

    public $nombre;
    public $direccion;

    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:sedes,nombre,' . $this->sede->id,
            'direccion' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->sede = Sede::findOrFail($id);

        $this->nombre = $this->sede->nombre;
        $this->direccion = $this->sede->direccion;
        $this->activo = $this->sede->activo;
    }

    public function store()
    {
        $this->validate();

        $this->sede->update([
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }
    
    #[On('eliminarSedeOn')]
    public function eliminarSedeOn()
    {
        if ($this->sede) {
            $this->sede->delete();

            return redirect()->route('admin.sede.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.admin.sede.sede-editar-livewire');
    }
}
