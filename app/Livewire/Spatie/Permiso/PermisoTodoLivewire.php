<?php

namespace App\Livewire\Spatie\Permiso;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.admin.layout-admin')]
class PermisoTodoLivewire extends Component
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
        $items = Permission::where('name', 'like', "%{$this->buscar}%")
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.spatie.permiso.permiso-todo-livewire', [
            'items' => $items,
        ]);
    }
}
