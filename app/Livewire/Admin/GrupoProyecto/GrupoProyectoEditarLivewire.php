<?php

namespace App\Livewire\Admin\GrupoProyecto;

use App\Models\GrupoProyecto;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class GrupoProyectoEditarLivewire extends Component
{
    public $grupo_proyecto;

    public $nombre;
    public $slug;
    public $titulo;
    public $subtitulo;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:grupo_proyectos,nombre,' . $this->grupo_proyecto->id,
            'slug' => 'required|unique:grupo_proyectos,slug,' . $this->grupo_proyecto->id,
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ];
    }

    public function mount($id)
    {
        $this->grupo_proyecto = GrupoProyecto::findOrFail($id);

        $this->nombre = $this->grupo_proyecto->nombre;
        $this->slug = $this->grupo_proyecto->slug;
        $this->titulo = $this->grupo_proyecto->titulo;
        $this->subtitulo = $this->grupo_proyecto->subtitulo;
        $this->activo = $this->grupo_proyecto->activo;
    }

    public function updatedNombre($value)
    {
        $this->slug = Str::slug($value);
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $this->grupo_proyecto->update([
            'nombre' => $this->nombre,
            'slug' => $this->slug,
            'titulo' => $this->titulo,
            'subtitulo' => $this->subtitulo,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Actualizado', 'text' => 'Se actualizo correctamente.']);
    }

    #[On('eliminarGrupoProyectoOn')]
    public function eliminarGrupoProyectoOn()
    {
        if ($this->grupo_proyecto) {
            $this->grupo_proyecto->delete();

            return redirect()->route('admin.grupo-proyecto.vista.todo');
        }
    }

    public function render()
    {
        return view('livewire.admin.grupo-proyecto.grupo-proyecto-editar-livewire');
    }
}
