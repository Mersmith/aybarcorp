<?php

namespace App\Livewire\Admin\Cliente;

use App\Services\SlinService;
use App\Models\Cliente;
use App\Models\UnidadNegocio;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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

    public function buscarCliente(SlinService $slinService)
    {
        $this->validate([
            'dni' => 'required',
        ]);

        $cliente = app()->environment('production')
            ? Http::get("https://aybarcorp.com/slin/cliente/{$this->dni}")->json()
            : $slinService->getClientePorDni($this->dni);

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
            'rol' => 'cliente',
            'activo' => true,
        ]);

        $cliente_nuevo = Cliente::create([
            'user_id' => $user->id,
            'dni' => $this->dni,
            'email' => $this->email,
        ]);

        foreach ($this->cliente_encontrado['empresas'] as $empresaJson) {

            $unidad = UnidadNegocio::firstOrCreate(
                ['nombre' => $empresaJson['razon_social']],
                ['razon_social' => $empresaJson['razon_social']]
            );

            $cliente_nuevo->unidadesNegocio()->attach($unidad->id, [
                'codigo' => $empresaJson['codigo'],
                'id_empresa' => $empresaJson['id_empresa'],
            ]);
        }

        //Password::sendResetLink(['email' => $user->email]);

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
