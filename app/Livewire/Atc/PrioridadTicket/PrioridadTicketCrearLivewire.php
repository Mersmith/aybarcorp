<?php

namespace App\Livewire\Atc\PrioridadTicket;

use App\Models\PrioridadTicket;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class PrioridadTicketCrearLivewire extends Component
{
    public $nombre;
    public $icono;
    public $color;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:prioridad_tickets,nombre',
            'activo' => 'required|boolean',
        ];
    }

    public function store()
    {
        $this->validate();

        PrioridadTicket::create([
            'nombre' => $this->nombre,
            'icono' => $this->icono,
            'color' => $this->color,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.prioridad-ticket.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.prioridad-ticket.prioridad-ticket-crear-livewire');
    }
}
