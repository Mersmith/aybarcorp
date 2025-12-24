<?php

namespace App\Livewire\Atc\EstadoEvidenciaPago;

use App\Models\EstadoEvidenciaPago;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class EstadoEvidenciaPagoTodoLivewire extends Component
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
        $estados = EstadoEvidenciaPago::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.atc.estado-evidencia-pago.estado-evidencia-pago-todo-livewire', compact('estados'));
    }
}
