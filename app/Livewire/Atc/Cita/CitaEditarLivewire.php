<?php

namespace App\Livewire\Atc\Cita;

use App\Models\Cita;
use App\Models\EstadoCita;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;

#[Layout('layouts.admin.layout-admin')]
class CitaEditarLivewire extends Component
{
    public $ticket;

    public $cita;
    public $estados, $estado_cita_id = '';

    public $asunto_respuesta;
    public $descripcion_respuesta;

    public $gestores, $gestor_id = '';

    protected function rules()
    {
        return [
            'gestor_id' => 'required',
            'estado_cita_id' => 'required',
        ];
    }

    public function mount($id)
    {
        $this->cita = Cita::findOrFail($id);
        $this->ticket = $this->cita->ticket;

        $this->asunto_respuesta = $this->cita->asunto_respuesta;
        $this->descripcion_respuesta = $this->cita->descripcion_respuesta;
        $this->estado_cita_id = $this->cita->estado_cita_id;
        $this->gestor_id = $this->cita->gestor_id;

        $this->estados = EstadoCita::all();

        $this->gestores = User::role('asesor-atc')
            ->where('rol', 'admin')
            ->get();
    }

    public function store()
    {
        $this->validate();

        $this->cita->update([
            'gestor_id' => $this->gestor_id,
            'estado_cita_id' => $this->estado_cita_id,
            'asunto_respuesta' => $this->asunto_respuesta,
            'descripcion_respuesta' => $this->descripcion_respuesta,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
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
