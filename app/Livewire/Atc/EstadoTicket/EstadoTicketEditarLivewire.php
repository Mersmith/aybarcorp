<?php

namespace App\Livewire\Atc\EstadoTicket;

use App\Models\EstadoTicket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class EstadoTicketEditarLivewire extends Component
{
    public $estado_ticket;

    public $nombre;
    public $icono;
    public $color;

    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:estado_tickets,nombre,' . $this->estado_ticket->id,
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->estado_ticket = EstadoTicket::findOrFail($id);

        $this->nombre = $this->estado_ticket->nombre;
        $this->icono = $this->estado_ticket->icono;
        $this->color = $this->estado_ticket->color;
        $this->activo = $this->estado_ticket->activo;
    }

    public function store()
    {
        $this->validate();

        $this->estado_ticket->update([
            'nombre' => $this->nombre,
            'icono' => $this->icono,
            'color' => $this->color,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    #[On('eliminarEstadoTicketOn')]
    public function eliminarEstadoTicketOn()
    {
        if ($this->estado_ticket) {
            $this->estado_ticket->delete();

            return redirect()->route('admin.estado-ticket.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.atc.estado-ticket.estado-ticket-editar-livewire');
    }
}
