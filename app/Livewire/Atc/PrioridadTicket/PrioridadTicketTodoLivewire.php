<?php

namespace App\Livewire\Atc\PrioridadTicket;

use App\Models\PrioridadTicket;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class PrioridadTicketTodoLivewire extends Component
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
        $items = PrioridadTicket::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.prioridad-ticket.prioridad-ticket-todo-livewire', compact('items'));
    }
}
