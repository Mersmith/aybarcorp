<?php

namespace App\Livewire\Marketing\Archivo;

use App\Models\Archivo;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ArchivoEditarLivewire extends Component
{
    use WithFileUploads;

    public $archivo_original;

    public $archivoId, $titulo, $descripcion, $url, $archivo_edit;

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        //'archivo_edit' => 'nullable|image|max:2048',
    ];

    public function mount($archivoId)
    {
        $archivo = Archivo::findOrFail($archivoId);
        $this->archivo_original = $archivo;
        $this->archivoId = $archivo->id;
        $this->titulo = $archivo->titulo;
        $this->descripcion = $archivo->descripcion;
        $this->url = $archivo->url;
    }

    public function editarFormulario()
    {
        $this->validate();

        $archivo = Archivo::findOrFail($this->archivoId);
        $archivo->titulo = $this->titulo;
        $archivo->descripcion = $this->descripcion;

        if ($this->archivo_edit) {
            if ($archivo->path && Storage::disk('public')->exists($archivo->path)) {
                Storage::disk('public')->delete($archivo->path);
            }

            $ruta = $this->archivo_edit->store('archivos', 'public');
            $archivo->path = $ruta;
            $archivo->url = Storage::url($ruta);
        }

        $archivo->save();

        //$this->dispatch('alertaLivewire', "Archivo actualizada correctamente.");
        $this->dispatch('formularioArchivoGuardada');
        $this->dispatch('cerrarModalEditarArchivo');
    }

    public function render()
    {
        return view('livewire.marketing.archivo.archivo-editar-livewire');
    }
}
