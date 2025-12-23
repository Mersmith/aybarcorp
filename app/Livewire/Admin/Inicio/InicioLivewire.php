<?php

namespace App\Livewire\Admin\Inicio;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admin.layout-admin')]
class InicioLivewire extends Component
{
    public $usuario;
    public $name;

    public $areasUsuario = [];

    public $roles = [];
    public $rolesConPermisos = [];

    public function mount()
    {
        $this->usuario = auth()->user();

        $this->name = $this->usuario->name;

        $this->areasUsuario = $this->usuario
            ->areas()
            ->with(['tipos']) // pivot y tipos
            ->get();

        $this->roles = $this->usuario->roles;

        $this->rolesConPermisos = $this->usuario->roles->map(function ($rol) {
            return [
                'nombre' => $rol->name,
                'permisos' => $rol->permissions->pluck('name'),
            ];
        });
    }

    public function actualizarDatos()
    {
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        $this->usuario->name = $this->name;
        $this->usuario->save();

        $this->usuario->load('areas');
        $this->areasUsuario = $this->usuario->areas()->withPivot('created_at')->get();

        $this->dispatch('alertaLivewire', "Actualizado");
    }


    public function render()
    {
        return view('livewire.admin.inicio.inicio-livewire');
    }
}
