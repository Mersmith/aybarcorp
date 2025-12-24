<?php

namespace App\Livewire\Admin\Proyecto;

use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class ProyectoCrearLivewire extends Component
{
    public $nombre;
    public $slug;
    public $imagen;
    public $contenido;
    public $meta_title;
    public $meta_description;
    public $meta_image;
    public $activo = false;

    public $lista = [];

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'slug' => 'required|unique:proyectos,slug',
            'imagen' => 'required|string|max:255',
            'contenido' => 'required|string',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'meta_image' => 'required|string|max:255',
            'activo' => 'required|boolean',
            'lista.*.id' => 'required|integer',
            'lista.*.texto' => 'required|string',
            'lista.*.link' => 'required|string',
        ];
    }

    public function updatedNombre($value)
    {
        $this->slug = Str::slug($value);
    }

    public function agregarItem()
    {
        $maxId = collect($this->lista)->max('id');
        $nextId = $maxId ? $maxId + 1 : 1;

        $this->lista[] = [
            'id' => $nextId,
            'texto' => '',
            'texto_color' => '#000000',
            'link' => '',
            'boton_color' => '#000000',
        ];
    }

    public function eliminarItem($index)
    {
        array_splice($this->lista, $index, 1);
    }

    public function crearPost()
    {
        $this->validate();

        Proyecto::create([
            'nombre' => $this->nombre,
            'slug' => $this->slug,
            'contenido' => $this->contenido,
            'imagen' => $this->imagen,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_image' => $this->meta_image,
            'activo' => $this->activo,
            'documento' => [
                'lista' => $this->lista,
            ],
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.blog.vista.todo');
    }

    #[On('handleProyectoCrearOn')]
    public function handleProyectoCrearOn($item, $position)
    {
        $index = array_search($item, array_column($this->lista, 'id'));

        if ($index !== false) {
            $element = array_splice($this->lista, $index, 1)[0];
            array_splice($this->lista, $position, 0, [$element]);
        }
    }

    public function render()
    {
        return view('livewire.admin.proyecto.proyecto-crear-livewire');
    }
}
