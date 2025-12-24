<?php

namespace App\Livewire\Admin\Proyecto;

use App\Models\Proyecto;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class ProyectoTodoLivewire extends Component
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
        $items = Proyecto::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.proyecto.proyecto-todo-livewire', compact('items'));
    }
}
