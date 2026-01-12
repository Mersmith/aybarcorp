<?php

namespace App\Livewire\Admin\Cliente;

use App\Exports\ClientesWebExport;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.admin.layout-admin')]
class ClienteTodoLivewire extends Component
{
    use WithPagination;
    public $buscar = '';
    public $perPage = 20;
    public $activo = '';
    public $verificado = '';
    public $email = '';
    public $tratamiento = '';
    public $politica = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';

    public function updatingFechaInicio()
    {
        $this->resetPage();
    }

    public function updatingFechaFin()
    {
        $this->resetPage();
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function updatingEmail()
    {
        $this->resetPage();
    }

    public function updatingActivo()
    {
        $this->resetPage();
    }

    public function updatingTratamiento()
    {
        $this->resetPage();
    }

    public function updatingPolitica()
    {
        $this->resetPage();
    }

    public function updatingVerificado()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFiltros()
    {
        $this->reset([
            'buscar',
            'email',
            'activo',
            'verificado',
            'tratamiento',
            'politica',
            'fecha_inicio',
            'fecha_fin',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function exportExcel()
    {
        return Excel::download(
            new ClientesWebExport(
                $this->buscar,
                $this->email,
                $this->activo,
                $this->verificado,
                $this->tratamiento,
                $this->politica,
                $this->fecha_inicio,
                $this->fecha_fin,
                $this->perPage,
                $this->getPage()
            ),
            'clientes_web.xlsx'
        );
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
            ->when($this->activo !== '', function ($query) {
                $query->where('activo', $this->activo);
            })
            ->when($this->tratamiento !== '', function ($query) {
                $query->where('politica_uno', $this->tratamiento);
            })
            ->when($this->politica !== '', function ($query) {
                $query->where('politica_dos', $this->politica);
            })
            ->when($this->verificado !== '', function ($query) {
                if ($this->verificado == '1') {
                    $query->whereNotNull('email_verified_at'); // Usuarios verificados
                } else {
                    $query->whereNull('email_verified_at'); // Usuarios no verificados
                }
            })
            ->when(
                $this->fecha_inicio,
                fn($q) =>
                $q->whereDate('users.created_at', '>=', $this->fecha_inicio)
            )
            ->when(
                $this->fecha_fin,
                fn($q) =>
                $q->whereDate('users.created_at', '<=', $this->fecha_fin)
            )
            ->where('users.email', 'like', '%' . $this->email . '%') // ← aquí
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.cliente.cliente-todo-livewire', [
            'items' => $items,
        ]);
    }
}
