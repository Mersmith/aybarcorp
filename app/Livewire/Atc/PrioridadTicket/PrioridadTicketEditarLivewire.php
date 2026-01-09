<?php

namespace App\Livewire\Atc\PrioridadTicket;

use App\Models\PrioridadTicket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

#[Layout('layouts.admin.layout-admin')]
class PrioridadTicketEditarLivewire extends Component
{
    public $prioridad;

    public $nombre;
    public $icono;
    public $color;

    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:prioridad_tickets,nombre,' . $this->prioridad->id,
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->prioridad = PrioridadTicket::findOrFail($id);

        $this->nombre = $this->prioridad->nombre;
        $this->icono = $this->prioridad->icono;
        $this->color = $this->prioridad->color;
        $this->activo = $this->prioridad->activo;
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->prioridad->update([
            'nombre' => $this->nombre,
            'icono' => $this->icono,
            'color' => $this->color,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    #[On('eliminarPrioridadTicketOn')]
    public function eliminarPrioridadTicketOn()
    {
        if ($this->prioridad) {
            $this->prioridad->delete();

            return redirect()->route('admin.prioridad-ticket.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.atc.prioridad-ticket.prioridad-ticket-editar-livewire');
    }
}
