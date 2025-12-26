<?php

namespace App\Livewire\Spatie\Rol;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin.layout-admin')]
class RolTodoLivewire extends Component
{
    use WithPagination;
    public $buscar = '';
    public $perPage = 20;

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset([
            'buscar',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function render()
    {
        $items = Role::where('name', '!=', 'super-admin')
            ->where('name', 'like', "%{$this->buscar}%")
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.spatie.rol.rol-todo-livewire', [
            'items' => $items,
        ]);
    }
}
