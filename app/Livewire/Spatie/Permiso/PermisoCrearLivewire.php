<?php

namespace App\Livewire\Spatie\Permiso;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.admin.layout-admin')]
class PermisoCrearLivewire extends Component
{
    public $name;

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $this->name]);

        $this->dispatch('alertaLivewire', 'Creado');

        return redirect()->route('admin.permiso.vista.todo');
    }

    public function render()
    {
        return view('livewire.spatie.permiso.permiso-crear-livewire');
    }
}
