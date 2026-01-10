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

    public $perPageDisponibles = 20;

    public function mount($id)
    {
        $this->area = Area::findOrFail($id);
    }

    public function updatingSearchAgregados()
    {
        $this->resetPage();
    }

    public function updatingSearchDisponibles()
    {
        $this->resetPage();
    }

    public function marcarPrincipal($userId)
    {
        // Quitar principal actual del área
        $this->area->usuarios()->updateExistingPivot(
            $this->area->usuarios()
                ->wherePivot('is_principal', true)
                ->pluck('users.id')
                ->toArray(),
            ['is_principal' => false]
        );

        // Marcar nuevo principal
        $this->area->usuarios()->updateExistingPivot(
            $userId,
            ['is_principal' => true]
        );

        $this->dispatch('alertaLivewire', [
            'title' => 'Actualizado',
            'text' => 'Usuario principal asignado correctamente.',
        ]);
    }

    public function agregarUsuario($userId)
    {
        $this->area->usuarios()->syncWithoutDetaching([$userId]);

        $this->dispatch('alertaLivewire', ['title' => 'Agregado', 'text' => 'Se agrego correctamente.']);
    }

    public function quitarUsuario($userId)
    {
        $this->area->usuarios()->detach($userId);

        $this->dispatch('alertaLivewire', ['title' => 'Quitado', 'text' => 'Se quito correctamente.']);
    }

    public function render()
    {
        $usuariosAgregados = $this->area->usuarios()
            ->where('rol', 'admin')
            ->where('name', 'like', '%' . $this->searchAgregados . '%')
            ->orderBy('name')
            ->get();

        $idsAgregados = $usuariosAgregados->pluck('id');

        $usuariosDisponibles = User::whereNotIn('id', $idsAgregados)
            ->where('rol', 'admin')
            ->where('name', 'like', '%' . $this->searchDisponibles . '%')
            ->orderBy('name')
            ->paginate($this->perPageDisponibles);

        return view('livewire.atc.area.area-user-livewire', compact(
            'usuariosAgregados',
            'usuariosDisponibles'
        ));
    }

}
