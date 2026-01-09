<?php

namespace App\Livewire\Admin\GrupoProyecto;

use App\Models\GrupoProyecto;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class GrupoProyectoCrearLivewire extends Component
{
    public $nombre;
    public $slug;
    public $titulo;
    public $subtitulo;
    public $activo = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|unique:grupo_proyectos,nombre',
            'slug' => 'required|unique:grupo_proyectos,slug',
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ];
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

        GrupoProyecto::create([
            'nombre' => $this->nombre,
            'slug' => $this->slug,
            'titulo' => $this->titulo,
            'subtitulo' => $this->subtitulo,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Creado', 'text' => 'Se guardó correctamente.']);

        return redirect()->route('admin.grupo-proyecto.vista.todo');
    }

    public function render()
    {
        return view('livewire.admin.grupo-proyecto.grupo-proyecto-crear-livewire');
    }
}
