<?php

namespace App\Livewire\Spatie\Rol;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin.layout-admin')]
class RolCrearLivewire extends Component
{
    public $name;
    public $permisosSeleccionados = [];

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $rol = Role::create(['name' => $this->name]);

        $rol->syncPermissions($this->permisosSeleccionados);

        $this->dispatch('alertaLivewire', 'Creado');

        return redirect()->route('admin.rol.vista.todo');
    }

    public function render()
    {
        return view('livewire.spatie.rol.rol-crear-livewire', [
            'permisos' => Permission::all(),
        ]);
    }
}
