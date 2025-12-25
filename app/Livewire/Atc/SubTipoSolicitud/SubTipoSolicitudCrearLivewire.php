<?php

namespace App\Livewire\Atc\SubTipoSolicitud;

use App\Models\TipoSolicitud;
use App\Models\SubTipoSolicitud;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class SubTipoSolicitudCrearLivewire extends Component
{
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

    public function mount()
    {
        $this->tipos = TipoSolicitud::all();
    }

    public function store()
    {
        $this->validate();

        SubTipoSolicitud::create([
            'tipo_solicitud_id' => $this->tipo_solicitud_id,
            'nombre' => $this->nombre,
            'tiempo_solucion' => $this->tiempo_solucion,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.sub-tipo-solicitud.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.sub-tipo-solicitud.sub-tipo-solicitud-crear-livewire');
    }
}
