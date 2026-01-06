<?php

namespace App\Livewire\Admin\User;

use App\Exports\AdminsExport;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin.layout-admin')]
class UserTodoLivewire extends Component
{
    use WithPagination;
    public $buscar = '';
    public $email = '';
    public $perPage = 20;
    public $roles, $rol = '';
    public $activo = '';

    public $totalUsers = 0;
    public $totalUsersActivo = 0;

    public function mount()
    {
        $this->roles = Role::whereNotIn('name', ['super-admin'])->get();

        /*$this->totalUsers = User::where('rol', 'admin')
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['super-admin', 'cliente']);
            })
            ->count();

        $this->totalUsersActivo = User::where('rol', 'admin')
            ->where('activo', 1)
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['super-admin', 'cliente']);
            })
            ->count();*/
    }

    public function updatingRol()
    {
        $this->resetPage();
    }

    public function updatingActivo()
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

    public function resetFiltros()
    {
        $this->reset([
            'buscar',
            'rol',
            'activo',
            'email',
        ]);

        $this->perPage = 20;
        $this->resetPage();
    }

    public function exportExcel()
    {
        return Excel::download(
            new AdminsExport(
                $this->buscar,
                $this->perPage,
                $this->getPage()
            ),
            'admins.xlsx'
        );
    }

    public function render()
    {
        $items = User::with('roles')
            ->where('rol', 'admin')
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['super-admin', 'cliente']);
            })
            ->when($this->rol, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('id', $this->rol);
                });
            })
            ->when($this->activo !== '', function ($query) {
                $query->where('activo', $this->activo);
            })
            ->where('name', 'like', '%' . $this->buscar . '%')
            ->where('email', 'like', '%' . $this->email . '%')
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.admin.user.user-todo-livewire', [
            'items' => $items,
        ]);
    }
}
