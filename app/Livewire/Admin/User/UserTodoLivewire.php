<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class UserTodoLivewire extends Component
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
        $items = User::with('roles')
            ->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'super-admin');
            })
            ->where('name', 'like', '%' . $this->buscar . '%')
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.admin.user.user-todo-livewire', [
            'items' => $items,
        ]);
    }
}
