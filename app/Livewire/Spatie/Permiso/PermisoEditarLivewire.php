<?php

namespace App\Livewire\Spatie\Permiso;

use Illuminate\Validation\ValidationException;
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
        try {
            $this->validate([
                'name' => 'required|unique:permissions,name,' . $this->permiso->id,
            ]);
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->permiso->update([
            'name' => $this->name,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    public function render()
    {
        return view('livewire.spatie.permiso.permiso-editar-livewire');
    }
}
