<?php

namespace App\Livewire\Atc\SubTipoSolicitud;

use App\Models\SubTipoSolicitud;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class SubTipoSolicitudTodoLivewire extends Component
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
        $items = SubTipoSolicitud::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.sub-tipo-solicitud.sub-tipo-solicitud-todo-livewire', compact('items'));
    }
}
