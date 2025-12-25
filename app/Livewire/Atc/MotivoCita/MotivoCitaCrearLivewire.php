<?php

namespace App\Livewire\Atc\MotivoCita;

use App\Models\MotivoCita;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class MotivoCitaCrearLivewire extends Component
{
    public $nombre;
    public $icono;
    public $color;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:motivo_citas,nombre',
            'activo' => 'required|boolean',
        ];
    }

    public function crearTipoSolicitud()
    {
        $this->validate();

        MotivoCita::create([
            'nombre' => $this->nombre,
            'icono' => $this->icono,
            'color' => $this->color,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.motivo-cita.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.motivo-cita.motivo-cita-crear-livewire');
    }
}
