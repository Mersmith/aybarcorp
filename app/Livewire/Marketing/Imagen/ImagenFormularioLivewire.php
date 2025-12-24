<?php

namespace App\Livewire\Marketing\Imagen;

use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImagenFormularioLivewire extends Component
{
    use WithFileUploads;

    public $imagenes_inicial = [], $imagenes_final = [];

    public function updatedImagenesInicial($imagenes_inicial)
    {
        foreach ($imagenes_inicial as $imagen) {
            $this->imagenes_final[] = $imagen;
        }
    }

    public function eliminarImagenTemporal($index)
    {
        array_splice($this->imagenes_final, $index, 1);
    }

    public function guardar()
    {
        if (empty($this->imagenes_final)) {
            $this->addError('imagenes_final', 'Debe seleccionar al menos una imagen.');
            return;
        }

        foreach ($this->imagenes_final as $imagen) {
            $ruta = $imagen->store('imagenes', 'public');
            $url = Storage::url($ruta);

            Imagen::create([
                'titulo' => null,
                'descripcion' => null,
                'path' => $ruta,
                'url' => $url,
            ]);
        }

        $this->reset(['imagenes_inicial', 'imagenes_final']);
        $this->resetErrorBag();

        //$this->dispatch('alertaLivewire', "Imágenes subidas correctamente.");
        $this->dispatch('formularioImagenGuardada');
    }

    public function render()
    {
        return view('livewire.marketing.imagen.imagen-formulario-livewire');
    }
}
