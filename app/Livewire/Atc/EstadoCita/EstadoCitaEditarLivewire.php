<?php

namespace App\Livewire\Atc\EstadoCita;

use App\Models\EstadoCita;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class EstadoCitaEditarLivewire extends Component
{
    public $estado;

    public $nombre;
    public $icono;
    public $color;

    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:estado_citas,nombre,' . $this->estado->id,
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->estado = EstadoCita::findOrFail($id);

        $this->nombre = $this->estado->nombre;
        $this->icono = $this->estado->icono;
        $this->color = $this->estado->color;
        $this->activo = $this->estado->activo;
    }

    public function store()
    {
        $this->validate();

        $this->estado->update([
            'nombre' => $this->nombre,
            'icono' => $this->icono,
            'color' => $this->color,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    #[On('eliminarEstadoCitaOn')]
    public function eliminarEstadoCitaOn()
    {
        if ($this->estado) {
            $this->estado->delete();

            return redirect()->route('admin.estado-cita.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.atc.estado-cita.estado-cita-editar-livewire');
    }
}
