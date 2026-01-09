<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin.layout-admin')]
class UserEditarLivewire extends Component
{
    public $user;

    public $name;
    public $email;
    public $password = '';

    public $roles;
    public $selectedRoles = [];

    public $activo = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ];
    }

    public function mount($id)
    {
        $this->user = User::findOrFail($id);

        $this->roles = Role::all();
        $this->selectedRoles = $this->user->roles->pluck('name')->toArray();

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->activo = $this->user->activo;
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'activo' => $this->activo,
        ]);

        $this->user->syncRoles($this->selectedRoles);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    public function actualizarClave()
    {
        try {
            $this->validate([
                'password' => 'required|min:6',
            ]);
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    #[On('eliminarUserOn')]
    public function eliminarUserOn()
    {
        if ($this->user) {
            $this->user->delete();

            return redirect()->route('admin.usuario.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.admin.user.user-editar-livewire');
    }
}
