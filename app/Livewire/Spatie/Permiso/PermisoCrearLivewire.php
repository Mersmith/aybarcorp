<?php

namespace App\Livewire\Spatie\Permiso;

use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.admin.layout-admin')]
class PermisoCrearLivewire extends Component
{
    public $name;

    public function store()
    {
        try {

            $this->validate([
                'name' => 'required|unique:permissions,name',
            ]);
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        Permission::create(['name' => $this->name]);

        $this->dispatch('alertaLivewire', ['title' => 'Creado', 'text' => 'Se guardó correctamente.']);

        return redirect()->route('admin.permiso.vista.todo');
    }

    public function render()
    {
        return view('livewire.spatie.permiso.permiso-crear-livewire');
    }
}
