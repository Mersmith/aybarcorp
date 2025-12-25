<?php

namespace App\Livewire\Atc\SubTipoSolicitud;

use Livewire\Component;
use App\Models\TipoSolicitud;
use App\Models\SubTipoSolicitud;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.admin.layout-admin')]
class SubTipoSolicitudEditarLivewire extends Component
{
    public $sub_tipo;

    public $tipos, $tipo_solicitud_id = "";
    public $nombre;
    public $tiempo_solucion;
    public $activo = false;

    protected function rules()
    {
        return [
            'tipo_solicitud_id' => 'required',
            'nombre' => 'required|string|max:255',
            'tiempo_solucion' => 'nullable|integer|min:1',
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->sub_tipo = SubTipoSolicitud::findOrFail($id);

        $this->tipo_solicitud_id = $this->sub_tipo->tipo_solicitud_id;
        $this->nombre = $this->sub_tipo->nombre;
        $this->tiempo_solucion = $this->sub_tipo->tiempo_solucion;
        $this->activo = $this->sub_tipo->activo;

        $this->tipos = TipoSolicitud::all();
    }

    public function store()
    {
        $this->validate();

        $this->sub_tipo->update([
            'tipo_solicitud_id' => $this->tipo_solicitud_id,
            'nombre' => $this->nombre,
            'tiempo_solucion' => $this->tiempo_solucion,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    #[On('eliminarSubTipoSolicitudOn')]
    public function eliminarSubTipoSolicitudOn()
    {
        if ($this->sub_tipo) {
            $this->sub_tipo->delete();

            return redirect()->route('admin.sub-tipo-solicitud.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.atc.sub-tipo-solicitud.sub-tipo-solicitud-editar-livewire');
    }
}
