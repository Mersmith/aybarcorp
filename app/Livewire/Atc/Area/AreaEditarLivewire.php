<?php

namespace App\Livewire\Atc\Area;

use App\Models\Area;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class AreaEditarLivewire extends Component
{
    public $area;

    public $nombre;
    public $email;

    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:areas,nombre,' . $this->area->id,
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->area = Area::findOrFail($id);

        $this->nombre = $this->area->nombre;
        $this->email = $this->area->email_buzon;
        $this->activo = $this->area->activo;
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->area->update([
            'nombre' => $this->nombre,
            'email_buzon' => $this->email,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    #[On('eliminarAreaOn')]
    public function eliminarAreaOn()
    {
        if ($this->area) {
            $this->area->delete();

            return redirect()->route('admin.area.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.atc.area.area-editar-livewire');
    }
}
