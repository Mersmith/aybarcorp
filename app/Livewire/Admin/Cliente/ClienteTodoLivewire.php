<?php

namespace App\Livewire\Admin\Cliente;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class ClienteTodoLivewire extends Component
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
        $items = User::query()
            ->where('rol', 'cliente')
            ->leftJoin('clientes', 'clientes.user_id', '=', 'users.id')
            ->where(function ($q) {
                $q->where('users.name', 'like', '%' . $this->buscar . '%')
                    ->orWhere('clientes.dni', 'like', '%' . $this->buscar . '%');
            })
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.cliente.cliente-todo-livewire', [
            'items' => $items,
        ]);
    }
}
