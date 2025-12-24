<?php

namespace App\Livewire\Atc\Area;

use App\Models\Area;
use App\Models\TipoSolicitud;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.layout-admin')]
class AreaSolicitudLivewire extends Component
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
        $this->reset('pageDisponibles');
    }

    public function updatingSearchAgregados()
    {
        $this->resetPage();
    }

    public function agregarTipo($tipoId)
    {
        $this->area->tipos()->syncWithoutDetaching([$tipoId]);

        $this->dispatch('alertaLivewire', "Creado");
    }

    public function quitarTipo($tipoId)
    {
        $this->area->tipos()->detach($tipoId);

        $this->dispatch('alertaLivewire', "Eliminado");
    }

    public function render()
    {
        // IDs agregados
        $idsAgregados = $this->area->tipos->pluck('id');

        // Tipos agregados
        $tiposAgregados = TipoSolicitud::whereIn('id', $idsAgregados)
            ->where('nombre', 'like', '%' . $this->searchAgregados . '%')
            ->orderBy('nombre')
            ->get();

        // Tipos disponibles
        $tiposDisponibles = TipoSolicitud::whereNotIn('id', $idsAgregados)
            ->where('nombre', 'like', '%' . $this->searchDisponibles . '%')
            ->orderBy('nombre')
            ->paginate(20, ['*'], 'pageDisponibles');

        return view('livewire.atc.area.area-solicitud-livewire', [
            'tiposAgregados' => $tiposAgregados,
            'tiposDisponibles' => $tiposDisponibles,
        ]);
    }
}
