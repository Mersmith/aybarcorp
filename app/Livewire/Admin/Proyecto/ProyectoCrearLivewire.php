<?php

namespace App\Livewire\Admin\Proyecto;

use App\Models\GrupoProyecto;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class ProyectoCrearLivewire extends Component
{
    public $unidad_negocios, $unidad_negocio_id = "";
    public $grupo_proyectos, $grupo_proyecto_id = "";

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
            'unidad_negocio_id' => 'required',
            'grupo_proyecto_id' => 'required',
            'nombre' => 'required|unique:proyectos,nombre',
            'slug' => 'required|unique:proyectos,slug',
            'imagen' => 'nullable|string|max:255',
            'contenido' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_image' => 'nullable|string|max:255',
            'activo' => 'required|boolean',
            'lista' => 'nullable|array',

            'lista.*.id' => 'required|integer',
            'lista.*.texto' => 'required|string',
            'lista.*.link' => 'required|string',
        ];
    }

    public function mount()
    {
        $this->unidad_negocios = UnidadNegocio::all();
        $this->grupo_proyectos = GrupoProyecto::all();
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

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        Proyecto::create([
            'unidad_negocio_id' => $this->unidad_negocio_id,
            'grupo_proyecto_id' => $this->grupo_proyecto_id,
            'nombre' => $this->nombre,
            'slug' => $this->slug,
            'activo' => $this->activo,
            /*'contenido' => $this->contenido,
            'imagen' => $this->imagen,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_image' => $this->meta_image,
            'documento' => [
                'lista' => $this->lista,
            ],*/
        ]);

        $this->dispatch('alertaLivewire', ['title' => 'Creado', 'text' => 'Se guardó correctamente.']);

        return redirect()->route('admin.proyecto.vista.todo');
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
