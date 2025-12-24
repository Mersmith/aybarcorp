<?php

namespace App\Livewire\Atc\Canal;

use App\Models\Canal;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class CanalCrearLivewire extends Component
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

    public function store()
    {
        $this->validate();

        Canal::create([
            'nombre' => $this->nombre,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.canal.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.canal.canal-crear-livewire');
    }
}
