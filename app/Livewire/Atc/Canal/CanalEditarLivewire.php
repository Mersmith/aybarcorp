<?php

namespace App\Livewire\Atc\Canal;

use App\Models\Canal;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class CanalEditarLivewire extends Component
{
    public $canal;

    public $nombre;

    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:canals,nombre,' . $this->canal->id,
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->canal = Canal::findOrFail($id);

        $this->nombre = $this->canal->nombre;
        $this->activo = $this->canal->activo;
    }

    public function store()
    {
        $this->validate();

        $this->canal->update([
            'nombre' => $this->nombre,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    #[On('eliminarCanalOn')]
    public function eliminarCanalOn()
    {
        if ($this->canal) {
            $this->canal->delete();

            return redirect()->route('admin.canal.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.atc.canal.canal-editar-livewire');
    }
}
