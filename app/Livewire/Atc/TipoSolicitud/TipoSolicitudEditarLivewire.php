<?php

namespace App\Livewire\Atc\TipoSolicitud;

use App\Models\TipoSolicitud;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class TipoSolicitudEditarLivewire extends Component
{
    public $tipo_solicitud;

    public $nombre;

    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:tipo_solicituds,nombre,' . $this->tipo_solicitud->id,
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->tipo_solicitud = TipoSolicitud::findOrFail($id);

        $this->nombre = $this->tipo_solicitud->nombre;
        $this->activo = $this->tipo_solicitud->activo;
    }

    public function store()
    {
        $this->validate();

        $this->tipo_solicitud->update([
            'nombre' => $this->nombre,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    #[On('eliminarTipoSolicitudOn')]
    public function eliminarTipoSolicitudOn()
    {
        if ($this->tipo_solicitud) {
            $this->tipo_solicitud->delete();

            return redirect()->route('admin.tipo-solicitud.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.atc.tipo-solicitud.tipo-solicitud-editar-livewire');
    }
}
