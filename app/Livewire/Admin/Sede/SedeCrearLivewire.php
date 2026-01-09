<?php

namespace App\Livewire\Admin\Sede;

use App\Models\Sede;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class SedeCrearLivewire extends Component
{
    public $nombre;
    public $direccion;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:sedes,nombre',
            'direccion' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ];
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        Sede::create([
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Creado', 'text' => 'Se guardó correctamente.']);

        return redirect()->route('admin.sede.vista.todo');
    }

    public function render()
    {
        return view('livewire.admin.sede.sede-crear-livewire');
    }
}
