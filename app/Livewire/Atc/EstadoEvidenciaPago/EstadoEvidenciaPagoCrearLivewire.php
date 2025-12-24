<?php

namespace App\Livewire\Atc\EstadoEvidenciaPago;

use App\Models\EstadoEvidenciaPago;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class EstadoEvidenciaPagoCrearLivewire extends Component
{
    public $nombre;
    public $icono;
    public $color;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255|unique:estado_evidencia_pagos,nombre',
            'activo' => 'required|boolean',
        ];
    }

    public function store()
    {
        $this->validate();

        EstadoEvidenciaPago::create([
            'nombre' => $this->nombre,
            'icono' => $this->icono,
            'color' => $this->color,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.estado-evidencia-pago.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.estado-evidencia-pago.estado-evidencia-pago-crear-livewire');
    }
}
