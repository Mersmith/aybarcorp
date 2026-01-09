<?php

namespace App\Livewire\Atc\Area;

use App\Models\Area;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class AreaCrearLivewire extends Component
{
    public $nombre;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:areas,nombre',
            'activo' => 'required|boolean',
        ];
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        Area::create([
            'nombre' => $this->nombre,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Creado', 'text' => 'Se guardó correctamente.']);

        return redirect()->route('admin.area.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.area.area-crear-livewire');
    }
}
