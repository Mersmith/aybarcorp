<?php

namespace App\Livewire\Cita\MotivoCita;

use App\Models\MotivoCita;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

#[Layout('layouts.admin.layout-admin')]
class MotivoCitaEditarLivewire extends Component
{
    public $motivo;

    public $nombre;
    public $icono;
    public $color;

    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:motivo_citas,nombre,' . $this->motivo->id,
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->motivo = MotivoCita::findOrFail($id);

        $this->nombre = $this->motivo->nombre;
        $this->icono = $this->motivo->icono;
        $this->color = $this->motivo->color;
        $this->activo = $this->motivo->activo;
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->motivo->update([
            'nombre' => $this->nombre,
            'icono' => $this->icono,
            'color' => $this->color,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    #[On('eliminarMotivoCitaOn')]
    public function eliminarMotivoCitaOn()
    {
        if ($this->motivo) {
            $this->motivo->delete();

            return redirect()->route('admin.motivo-cita.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.cita.motivo-cita.motivo-cita-editar-livewire');
    }
}
