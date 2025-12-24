<?php

namespace App\Livewire\Atc\Area;

use App\Models\Area;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class AreaEditarLivewire extends Component
{
    public $area;

    public $nombre;

    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:areas,nombre,' . $this->area->id,
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->area = Area::findOrFail($id);

        $this->nombre = $this->area->nombre;
        $this->activo = $this->area->activo;
    }

    public function store()
    {
        $this->validate();

        $this->area->update([
            'nombre' => $this->nombre,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    #[On('eliminarAreaOn')]
    public function eliminarAreaOn()
    {
        if ($this->area) {
            $this->area->delete();

            return redirect()->route('admin.area.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.atc.area.area-editar-livewire');
    }
}
