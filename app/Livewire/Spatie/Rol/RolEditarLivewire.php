<?php

namespace App\Livewire\Spatie\Rol;

use Illuminate\Validation\ValidationException;
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
        try {
            $this->validate([
                'name' => 'required|unique:roles,name,' . $this->role->id,
            ]);
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->role->update([
            'name' => $this->name,
        ]);

        $this->role->syncPermissions($this->permisosSeleccionados);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    public function render()
    {
        return view('livewire.spatie.rol.rol-editar-livewire', [
            'permisos' => Permission::all(),
        ]);
    }
}
