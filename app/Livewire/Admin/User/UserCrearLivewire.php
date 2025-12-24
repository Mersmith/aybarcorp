<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.admin.layout-admin')]
class UserCrearLivewire extends Component
{
    public $name;
    public $email;
    public $password;
    public $rol = 'cliente';

    public $activo = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'rol' => 'required|in:admin,cliente',
        ];
    }

    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'rol' => $this->rol,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', 'Creado');

        return redirect()->route('admin.usuario.vista.todo');
    }

    public function render()
    {
        return view('livewire.admin.user.user-crear-livewire');
    }
}
