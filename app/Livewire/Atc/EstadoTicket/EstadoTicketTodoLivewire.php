<?php

namespace App\Livewire\Atc\EstadoTicket;

use App\Models\EstadoTicket;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class EstadoTicketTodoLivewire extends Component
{
    use WithPagination;
    public $buscar = '';
    public $perPage = 20;

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function render()
    {
        $items = EstadoTicket::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.estado-ticket.estado-ticket-todo-livewire', compact('items'));
    }
}
