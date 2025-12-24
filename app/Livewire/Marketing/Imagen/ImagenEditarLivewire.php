<?php

namespace App\Livewire\Marketing\Imagen;

use App\Models\Imagen;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ImagenEditarLivewire extends Component
{
    use WithFileUploads;

    public $imagenId, $titulo, $descripcion, $url, $imagen_edit;

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'imagen_edit' => 'nullable|image|max:2048',
    ];

    public function mount($imagenId)
    {
        $imagen = Imagen::findOrFail($imagenId);
        $this->imagenId = $imagen->id;
        $this->titulo = $imagen->titulo;
        $this->descripcion = $imagen->descripcion;
        $this->url = $imagen->url;
    }

    public function editarFormulario()
    {
        $this->validate();

        $imagen = Imagen::findOrFail($this->imagenId);
        $imagen->titulo = $this->titulo;
        $imagen->descripcion = $this->descripcion;

        if ($this->imagen_edit) {
            if ($imagen->path && Storage::disk('public')->exists($imagen->path)) {
                Storage::disk('public')->delete($imagen->path);
            }

            $ruta = $this->imagen_edit->store('imagenes', 'public');
            $imagen->path = $ruta;
            $imagen->url = Storage::url($ruta);
        }

        $imagen->save();

        //$this->dispatch('alertaLivewire', "Imagen actualizada correctamente.");
        $this->dispatch('formularioImagenGuardada');
        $this->dispatch('cerrarModalEditarImagen');
    }

    public function render()
    {
        return view('livewire.marketing.imagen.imagen-editar-livewire');
    }
}
