<?php

namespace App\Livewire\Admin\Cliente;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
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

    public function buscarCliente()
    {
        $this->resetAntesDeBuscar();

        $this->validate([
            'dni' => 'required',
        ]);

        $response = Http::get("https://aybarcorp.com/slin/cliente/{$this->dni}");

        if (!$response->ok()) {
            session()->flash('error', 'Error al consultar el servicio.');
            return;
        }

        $cliente = $response->json();

        if (!is_array($cliente)) {
            session()->flash('error', 'Respuesta inválida del servicio.');
            return;
        }

        $this->cliente_encontrado = $cliente;
        $this->razones_sociales = $cliente['empresas'] ?? [];

        $this->existingCliente = Cliente::where('dni', $this->dni)->first();

        if (!$this->existingCliente) {
            $this->mostrar_form_email = true;
            session()->flash('info', 'Cliente nuevo. Ingrese un correo para registrarlo.');
        } else {
            $this->mostrar_form_email = false;
            session()->flash('success', 'Cliente encontrado en el API Slin');
        }
    }

    public function resetAntesDeBuscar()
    {
        $this->reset([
            'cliente_encontrado',
            'razones_sociales',
            'existingCliente',
            'email',
            'mostrar_form_email',
        ]);

        $this->resetValidation();
        session()->forget(['success', 'error', 'info']);
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
            'nombre' => $$user->name,
            'email' => $this->email,
            'dni' => $this->dni,
        ]);

        Password::sendResetLink(['email' => $user->email]);

        session()->flash('success', "Cliente registrado. Contraseña temporal enviada al correo.");

        $this->existingCliente = $cliente_nuevo;
        $this->mostrar_form_email = false;
    }

    public function render()
    {
        return view('livewire.admin.cliente.cliente-crear-livewire');
    }
}
