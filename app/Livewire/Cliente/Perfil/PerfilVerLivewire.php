<?php

namespace App\Livewire\Cliente\Perfil;

use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PerfilVerLivewire extends Component
{
    public $cliente;

    public $nombre;
    public $apellido_paterno;
    public $apellido_materno;
    public $dni;
    public $telefono_principal;
    public $email;

    public $clave_actual;
    public $clave_nueva;

    public function mount()
    {
        $cliente = Cliente::where('user_id', Auth::id())->firstOrFail();

        // Asignar los valores del cliente a las propiedades del componente
        $this->cliente = $cliente;

        $this->nombre = $cliente->nombre;
        $this->apellido_paterno = $cliente->apellido_paterno;
        $this->apellido_materno = $cliente->apellido_materno;
        $this->dni = $cliente->dni;
        $this->telefono_principal = $cliente->telefono_principal;
        $this->email = $cliente->email;
    }

    public function actualizarDatos()
    {
        // Reglas de validación para actualizar datos
        $rules = [
            'nombre' => 'nullable|string|max:255',
            'apellido_paterno' => 'nullable|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'dni' => [
                'required',
                'string',
                'size:8',
                Rule::unique('clientes')->ignore(Auth::id(), 'user_id'),
            ],
            'telefono_principal' => 'nullable|string|max:15',
        ];

        $messages = [
            'dni.required' => 'El :attribute es obligatorio.',
            'dni.size' => 'El :attribute debe tener exactamente :size caracteres.',
            'dni.unique' => 'El :attribute ya está en uso.',
        ];

        $validationAttributes = [
            'nombre' => 'nombre',
            'apellido_paterno' => 'apellido paterno',
            'apellido_materno' => 'apellido materno',
            'dni' => 'DNI',
            'telefono_principal' => 'número de celular',
        ];

        $validatedData = $this->validate($rules, $messages, $validationAttributes);

        // Actualizar los datos del cliente
        $cliente = Cliente::where('user_id', Auth::id())->firstOrFail();
        $cliente->update($validatedData);

        // Redirigir con un mensaje de éxito
        session()->flash('success', 'Perfil actualizado correctamente.');
    }

    public function actualizarClave()
    {
        // Reglas de validación para actualizar clave
        $rules = [
            'clave_actual' => 'required|string',
            'clave_nueva' => 'required|string|min:8',
        ];

        $messages = [
            'clave_actual.required' => 'La :attribute es obligatoria.',
            'clave_nueva.required' => 'La :attribute es obligatoria.',
            'clave_nueva.min' => 'La :attribute debe tener al menos :min caracteres.',
        ];

        $validationAttributes = [
            'clave_actual' => 'contraseña actual',
            'clave_nueva' => 'nueva contraseña',
        ];

        $this->validate($rules, $messages, $validationAttributes);

        // Obtener el cliente autenticado
        $cliente = Cliente::where('user_id', Auth::id())->firstOrFail();

        // Verificar si la contraseña actual coincide
        if (!\Hash::check($this->clave_actual, $cliente->user->password)) {
            $this->addError('clave_actual', 'La contraseña actual no es correcta.');
            return;
        }

        // Actualizar la contraseña con la nueva
        $cliente->user->update([
            'password' => bcrypt($this->clave_nueva),
        ]);

        // Limpiar los campos de la contraseña después de la actualización
        $this->reset(['clave_actual', 'clave_nueva']);

        // Redirigir con un mensaje de éxito
        session()->flash('success', 'Contraseña actualizada correctamente.');
    }

    public function render()
    {
        return view('livewire.cliente.perfil.perfil-ver-livewire');
    }
}
