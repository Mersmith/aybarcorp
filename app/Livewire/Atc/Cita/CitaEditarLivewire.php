<?php

namespace App\Livewire\Atc\Cita;

use App\Models\Cita;
use App\Models\EstadoCita;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class CitaEditarLivewire extends Component
{
    public $cita;
    public $estados, $estado_cita_id = '';

    public $asunto_respuesta;
    public $descripcion_respuesta;

    protected function rules()
    {
        return [
            'estado_cita_id' => 'required',
        ];
    }

    public function mount($id)
    {
        $this->cita = Cita::findOrFail($id);
        $this->asunto_respuesta = $this->cita->asunto_respuesta;
        $this->descripcion_respuesta = $this->cita->descripcion_respuesta;
        $this->estado_cita_id = $this->cita->estado_cita_id;
        $this->estados = EstadoCita::all();
    }

    public function store()
    {
        $this->validate();

        $this->cita->update([
            'estado_cita_id' => $this->estado_cita_id,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    #[On('eliminarCitaOn')]
    public function eliminarCitaOn()
    {
        $cita = $this->cita->fresh();

        if ($cita->estado_cita_id != 2) {
            $this->dispatch('alertaLivewire', 'Solo se pueden eliminar tickets en estado CONFIRMADO.');
            return;
        }

        $cita->delete();

        return redirect()->route('admin.cita.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.cita.cita-editar-livewire');
    }
}
