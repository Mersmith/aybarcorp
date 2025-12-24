<?php

namespace App\Livewire\Atc\Area;

use App\Models\Area;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class AreaCrearLivewire extends Component
{
    public $nombre;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ];
    }

    public function crearArea()
    {
        $this->validate();

        Area::create([
            'nombre' => $this->nombre,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.area.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.area.area-crear-livewire');
    }
}
