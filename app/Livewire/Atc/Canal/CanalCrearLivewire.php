<?php

namespace App\Livewire\Atc\Canal;

use App\Models\Canal;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

#[Layout('layouts.admin.layout-admin')]
class CanalCrearLivewire extends Component
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
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        Canal::create([
            'nombre' => $this->nombre,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Creado', 'text' => 'Se guardó correctamente.']);

        return redirect()->route('admin.canal.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.canal.canal-crear-livewire');
    }
}
