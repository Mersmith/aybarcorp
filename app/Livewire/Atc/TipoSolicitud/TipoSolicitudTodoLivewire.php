<?php

namespace App\Livewire\Atc\TipoSolicitud;

use App\Models\TipoSolicitud;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class TipoSolicitudTodoLivewire extends Component
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
        $items = TipoSolicitud::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.tipo-solicitud.tipo-solicitud-todo-livewire', compact('items'));
    }
}
