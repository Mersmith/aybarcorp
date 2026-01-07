<?php

namespace App\Livewire\Admin\GrupoProyecto;

use App\Models\GrupoProyecto;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class GrupoProyectoTodoLivewire extends Component
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
        $items = GrupoProyecto::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.grupo-proyecto.grupo-proyecto-todo-livewire', compact('items'));
    }
}
