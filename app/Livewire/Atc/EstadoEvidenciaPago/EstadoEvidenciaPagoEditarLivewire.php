<?php

namespace App\Livewire\Atc\EstadoEvidenciaPago;

use App\Models\EstadoEvidenciaPago;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

#[Layout('layouts.admin.layout-admin')]
class EstadoEvidenciaPagoEditarLivewire extends Component
{
    public $estado;

    public $nombre;
    public $icono;
    public $color;

    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:estado_evidencia_pagos,nombre,' . $this->estado->id,
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->estado = EstadoEvidenciaPago::findOrFail($id);

        $this->nombre = $this->estado->nombre;
        $this->icono = $this->estado->icono;
        $this->color = $this->estado->color;
        $this->activo = $this->estado->activo;
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->estado->update([
            'nombre' => $this->nombre,
            'icono' => $this->icono,
            'color' => $this->color,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    #[On('eliminarEstadoEvidenciaPagoOn')]
    public function eliminarEstadoEvidenciaPagoOn()
    {
        if ($this->estado) {
            $this->estado->delete();

            return redirect()->route('admin.estado-evidencia-pago.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.atc.estado-evidencia-pago.estado-evidencia-pago-editar-livewire');
    }
}
