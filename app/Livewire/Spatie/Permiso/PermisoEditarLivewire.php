<?php

namespace App\Livewire\Spatie\Permiso;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.admin.layout-admin')]
class PermisoEditarLivewire extends Component
{
    public $permiso;

    public $name;

    public function mount($id)
    {
        $this->permiso = Permission::findOrFail($id);

        $this->name = $this->permiso->name;
    }

    public function store()
    {
        $this->validate([
            'permiso.name' => 'required|unique:permissions,name,' . $this->permiso->id,
        ]);

        $this->permiso->update([
            'name' => $this->name,
        ]);

        $this->dispatch('alertaLivewire', 'Actualizado');
    }

    public function render()
    {
        return view('livewire.spatie.permiso.permiso-editar-livewire');
    }
}
