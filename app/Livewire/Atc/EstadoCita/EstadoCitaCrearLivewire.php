<?php

namespace App\Livewire\Atc\EstadoCita;

use App\Models\EstadoCita;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class EstadoCitaCrearLivewire extends Component
{
    public $nombre;
    public $icono;
    public $color;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:estado_citas,nombre',
            'activo' => 'required|boolean',
        ];
    }

    public function crearTipoSolicitud()
    {
        $this->validate();

        EstadoCita::create([
            'nombre' => $this->nombre,
            'icono' => $this->icono,
            'color' => $this->color,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.estado-cita.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.estado-cita.estado-cita-crear-livewire');
    }
}
