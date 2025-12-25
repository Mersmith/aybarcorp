<?php

namespace App\Livewire\Atc\EstadoTicket;

use App\Models\EstadoTicket;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class EstadoTicketCrearLivewire extends Component
{
    public $nombre;
    public $icono;
    public $color;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:estado_tickets,nombre',
            'activo' => 'required|boolean',
        ];
    }

    public function store()
    {
        $this->validate();

        EstadoTicket::create([
            'nombre' => $this->nombre,
            'icono' => $this->icono,
            'color' => $this->color,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.estado-ticket.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.estado-ticket.estado-ticket-crear-livewire');
    }
}
