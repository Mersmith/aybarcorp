<?php

namespace App\Livewire\Web\Sesion;

use App\Models\Cliente;
use App\Models\User;
use App\Services\SlinService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.web.layout-web')]
class ClienteRegistrarLivewire extends Component
{
    public $dni;
    public $cliente_encontrado = null;

    public $email;
    public $password;
    public $password_confirmation;

    public $politica_uno = false;
    public $politica_dos = false;

    protected $rules = [
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'politica_uno' => 'accepted',
        'politica_dos' => 'nullable',
    ];

    protected $messages = [
        'politica_uno.accepted' => 'Debes aceptar la política de privacidad.',
        'politica_dos.accepted' => 'Debes aceptar los términos y condiciones.',
    ];

    public function buscarCliente(SlinService $slinService)
    {
        $this->cliente_encontrado = null;

        if (!$this->dni) {
            session()->flash('error', 'Debe ingresar un DNI.');
            return;
        }

        $existingCliente = Cliente::where('dni', $this->dni)->first();

        if ($existingCliente) {
            session()->flash(
                'error',
                "Ya existe una cuenta asociada a este DNI. Tu correo registrado es: {$existingCliente->email}. Recupera tu contraseña."
            );
            return;
        }

        $cliente = Http::get("https://aybarcorp.com/slin/cliente/{$this->dni}")->json();

        if (empty($cliente)) {
            session()->flash('error', 'Inténtelo más tarde, por favor.');
            return;
        }

        session()->flash('status', 'Ahora si puede crear tu cuenta');

        $this->cliente_encontrado = $cliente;
    }

    public function registrar()
    {
        if (!$this->cliente_encontrado) {
            session()->flash('error', 'Debe validar su DNI antes de registrarse.');
            return;
        }

        $this->validate();

        $user = User::create([
            'name' => $this->cliente_encontrado['apellidos_nombres'] ?? $this->email,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'politica_uno' => $this->politica_uno,
            'politica_dos' => $this->politica_dos,
            'rol' => 'cliente',
        ]);

        Cliente::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'dni' => $this->dni,
        ]);

        Auth::login($user);
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    public function render()
    {
        return view('livewire.web.sesion.registrar-cliente-crear-livewire');
    }
}
