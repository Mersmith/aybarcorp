<?php

namespace App\Livewire\Atc\TipoSolicitud;

use App\Models\TipoSolicitud;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class TipoSolicitudCrearLivewire extends Component
{
    public $nombre;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ];
    }

    public function store()
    {
        $this->validate();

        TipoSolicitud::create([
            'nombre' => $this->nombre,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.tipo-solicitud.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.tipo-solicitud.tipo-solicitud-crear-livewire');
    }
}
