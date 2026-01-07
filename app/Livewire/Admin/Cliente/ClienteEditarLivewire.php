<?php

namespace App\Livewire\Admin\Cliente;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class ClienteEditarLivewire extends Component
{
    public $user;

    public $name;
    public $email;
    public $dni;
    public $telefono_principal;

    public $rol = 'cliente';
    public $activo = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'dni' => 'required',
            'telefono_principal' => 'nullable',
        ];
    }

    public function mount($id)
    {
        $this->user = User::findOrFail($id);

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->activo = $this->user->activo;

        $this->dni = $this->user->cliente->dni;
        $this->telefono_principal = $this->user->cliente->telefono_principal;
    }

    public function store()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'rol' => $this->rol,
            'activo' => $this->activo,
        ]);

        $this->user->cliente->update([
            'nombre' => $this->name,
            'email' => $this->email,
            'dni' => $this->dni,
            'telefono_principal' => $this->telefono_principal,
        ]);

        $this->dispatch('alertaLivewire', 'Actualizado');
    }

    public function enviarRecuperarClave()
    {
        $this->validate([
            'email' => 'required',
        ]);

        Password::sendResetLink(['email' => $this->email]);
    }

    #[On('eliminarClienteOn')]
    public function eliminarClienteOn()
    {
        if ($this->user) {
            $this->user->delete();

            return redirect()->route('admin.cliente.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.admin.cliente.cliente-editar-livewire');
    }
}
