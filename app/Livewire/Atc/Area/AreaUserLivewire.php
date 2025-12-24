<?php

namespace App\Livewire\Atc\Area;

use App\Models\Area;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class AreaUserLivewire extends Component
{
    use WithPagination;

    public $area;

    public string $searchDisponibles = '';
    public string $searchAgregados = '';

    public $pageDisponibles = 1;

    public function mount($id)
    {
        $this->area = Area::findOrFail($id);
    }

    public function updatingSearchDisponibles()
    {
        $this->resetPage();
        $this->reset('pageDisponibles');
    }

    public function updatingSearchAgregados()
    {
        $this->resetPage();
    }

    public function agregarUsuario($userId)
    {
        $this->area->usuarios()->syncWithoutDetaching([$userId]);

        $this->dispatch('alertaLivewire', "Creado");
    }

    public function quitarUsuario($userId)
    {
        $this->area->usuarios()->detach($userId);

        $this->dispatch('alertaLivewire', "Eliminado");
    }

    public function render()
    {
        $idsAgregados = $this->area->usuarios->pluck('id');

        $usuariosAgregados = User::whereIn('id', $idsAgregados)
            ->where('rol', 'admin')
            ->where('name', 'like', '%' . $this->searchAgregados . '%')
            ->orderBy('name')
            ->get();

        $usuariosDisponibles = User::whereNotIn('id', $idsAgregados)
            ->where('rol', 'admin')
            ->where('name', 'like', '%' . $this->searchDisponibles . '%')
            ->orderBy('name')
            ->paginate(20, ['*'], 'pageDisponibles');

        return view('livewire.atc.area.area-user-livewire', [
            'usuariosAgregados' => $usuariosAgregados,
            'usuariosDisponibles' => $usuariosDisponibles,
        ]);
    }
}
