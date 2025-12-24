<?php

namespace App\Livewire\Spatie\Rol;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin.layout-admin')]
class RolEditarLivewire extends Component
{
    public $role;

    public $name;
    public $permisosSeleccionados = [];

    public function mount($id)
    {
        $this->role = Role::findOrFail($id);
        
        $this->name = $this->role->name;

        $this->permisosSeleccionados = $this->role->permissions->pluck('name')->toArray();
    }

    public function store()
    {
        $this->validate([
            'role.name' => 'required|unique:roles,name,' . $this->role->id,
        ]);

        $this->role->save();
        $this->role->syncPermissions($this->permisosSeleccionados);

        $this->dispatch('alertaLivewire', 'Actualizado');
    }

    public function render()
    {
        return view('livewire.spatie.rol.rol-editar-livewire', [
            'permisos' => Permission::all(),
        ]);
    }
}
