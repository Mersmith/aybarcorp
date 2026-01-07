<?php

namespace App\Livewire\Admin\GrupoProyecto;

use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\GrupoProyecto;

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
            'nombre' => 'required|string|max:255',
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
        $this->validate();

        GrupoProyecto::create([
            'nombre' => $this->nombre,
            'slug' => $this->slug,
            'titulo' => $this->titulo,
            'subtitulo' => $this->subtitulo,
            'activo' => $this->activo,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.grupo-proyecto.vista.todo');
    }

    public function render()
    {
        return view('livewire.admin.grupo-proyecto.grupo-proyecto-crear-livewire');
    }
}
