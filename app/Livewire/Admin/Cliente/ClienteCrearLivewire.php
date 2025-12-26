<?php

namespace App\Livewire\Admin\Cliente;

use App\Models\Cliente;
use App\Models\User;
use App\Services\SlinService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class ClienteCrearLivewire extends Component
{
    public $existingCliente;
    public $dni;
    public $email;
    public $mostrar_form_email = false;
    public $cliente_encontrado = null;
    public $razones_sociales = [];

    public function buscarCliente(SlinService $slinService)
    {
        $this->validate([
            'dni' => 'required',
        ]);

        $cliente = Http::get("https://aybarcorp.com/slin/cliente/{$this->dni}")->json();

        if (empty($cliente)) {
            session()->flash('error', 'Inténtelo más tarde, por favor.');
            return;
        }

        $this->cliente_encontrado = $cliente;
        $this->razones_sociales = $this->cliente_encontrado['empresas'];

        $this->existingCliente = Cliente::where('dni', $this->dni)->first();

        if (!$this->existingCliente) {
            $this->mostrar_form_email = true;
            session()->flash('info', 'Cliente nuevo. Ingrese un correo para registrarlo.');
        } else {
            $this->cliente_id = $this->existingCliente->user->id;
            $this->mostrar_form_email = false;
            session()->flash('success', 'Cliente encontrado en el sistema.');
        }
    }

    public function registrarClienteNuevo()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        $tempPassword = Str::random(8);

        $user = User::create([
            'name' => $this->cliente_encontrado['apellidos_nombres'],
            'email' => $this->email,
            'password' => Hash::make($tempPassword),
            'must_change_password' => true,
            'password_changed_at' => null,
            'rol' => 'cliente',
            'activo' => true,
        ]);

        $cliente_nuevo = Cliente::create([
            'user_id' => $user->id,
            'dni' => $this->dni,
            'email' => $this->email,
        ]);

        Password::sendResetLink(['email' => $user->email]);

        session()->flash('success', "Cliente registrado. Contraseña temporal enviada al correo.");

        $this->cliente_id = $user->id;
        $this->existingCliente = $cliente_nuevo;
        $this->mostrar_form_email = false;
    }

    public function render()
    {
        return view('livewire.admin.cliente.cliente-crear-livewire');
    }
}
