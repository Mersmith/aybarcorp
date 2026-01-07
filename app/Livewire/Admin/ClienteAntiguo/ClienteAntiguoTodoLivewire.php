<?php

namespace App\Livewire\Admin\ClienteAntiguo;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class ClienteAntiguoTodoLivewire extends Component
{
    use WithPagination;

    public $buscar = '';
    public $codigo_cliente = '';
    public $perPage = 20;

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function updatingCodigoCliente()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset([
            'buscar',
            'codigo_cliente',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function render()
    {
        $items = DB::table('clientes_2')
            ->when($this->buscar !== '', function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nombre', 'like', '%' . $this->buscar . '%')
                        ->orWhere('dni', 'like', '%' . $this->buscar . '%');
                });
            })
            ->when($this->codigo_cliente !== '', function ($q) {
                $q->where('codigo_cliente', $this->codigo_cliente);
            })
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.admin.cliente-antiguo.cliente-antiguo-todo-livewire', [
            'items' => $items,
        ]);
    }
}
