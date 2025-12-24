<?php

namespace App\Livewire\Admin\Proyecto;

use App\Models\Proyecto;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class ProyectoSeccionLivewire extends Component
{
    public Proyecto $proyecto;

    public $banner_imagen = '';
    public $banner_youtube = '';

    public $precio = [
        'texto' => '',
        'monto' => '',
    ];

    public $aviso = [
        'texto_1' => '',
        'texto_2' => '',
    ];

    public $iconos = [];
    public $imagen_mapa = '';
    public $ofrecemos = [];
    public $galeria = [];
    public $videos_youtube = [];
    public $turismo = [];

    public function mount($id)
    {
        $this->proyecto = Proyecto::findOrFail($id);

        $contenido = $this->proyecto->secciones ?? [];

        $this->banner_imagen = $contenido['banner_imagen'] ?? '';
        $this->banner_youtube = $contenido['banner_youtube'] ?? '';

        $this->precio = $contenido['precio'] ?? ['texto' => '', 'monto' => ''];
        $this->aviso = $contenido['aviso'] ?? ['texto_1' => '', 'texto_2' => ''];

        $this->iconos = $this->initItems($contenido['iconos'] ?? [], ['imagen', 'texto']);
        $this->ofrecemos = $this->initItems($contenido['ofrecemos'] ?? [], ['imagen', 'texto']);
        $this->galeria = $this->initItems($contenido['galeria'] ?? [], ['imagen']);
        $this->videos_youtube = $this->initItems($contenido['videos_youtube'] ?? [], ['iframe']);
        $this->turismo = $this->initItems($contenido['turismo'] ?? [], ['imagen', 'titulo', 'descripcion']);

        $this->imagen_mapa = $contenido['imagen_mapa'] ?? '';
    }

    private function initItems(array $items, array $fields): array
    {
        if (empty($items)) {
            return [$this->newItem($fields)];
        }

        return collect($items)->map(function ($item) use ($fields) {
            $item['id'] = $item['id'] ?? uniqid();
            foreach ($fields as $field) {
                $item[$field] = $item[$field] ?? '';
            }
            return $item;
        })->values()->toArray();
    }

    private function newItem(array $fields): array
    {
        $item = ['id' => uniqid()];
        foreach ($fields as $field) {
            $item[$field] = '';
        }
        return $item;
    }

    public function addIcono()
    {
        $this->iconos[] = $this->newItem(['imagen', 'texto']);
    }

    public function removeIcono($id)
    {
        $this->iconos = array_values(array_filter($this->iconos, fn($i) => $i['id'] !== $id));
    }

    public function addOfrecemos()
    {
        $this->ofrecemos[] = $this->newItem(['imagen', 'texto']);
    }

    public function removeOfrecemos($id)
    {
        $this->ofrecemos = array_values(array_filter($this->ofrecemos, fn($i) => $i['id'] !== $id));
    }

    public function addGaleria()
    {
        $this->galeria[] = $this->newItem(['imagen']);
    }

    public function removeGaleria($id)
    {
        $this->galeria = array_values(array_filter($this->galeria, fn($i) => $i['id'] !== $id));
    }

    public function addVideo()
    {
        $this->videos_youtube[] = $this->newItem(['iframe']);
    }

    public function removeVideo($id)
    {
        $this->videos_youtube = array_values(array_filter($this->videos_youtube, fn($i) => $i['id'] !== $id));
    }

    public function addTurismo()
    {
        $this->turismo[] = $this->newItem(['imagen', 'titulo', 'descripcion']);
        $this->dispatch('lista-updated', count($this->turismo));

    }

    public function removeTurismo($id)
    {
        $this->turismo = array_values(array_filter($this->turismo, fn($i) => $i['id'] !== $id));
    }

    public function store()
    {
        $this->proyecto->update([
            'secciones' => [
                'banner_imagen' => $this->banner_imagen,
                'banner_youtube' => $this->banner_youtube,
                'precio' => $this->precio,
                'aviso' => $this->aviso,
                'iconos' => array_values($this->iconos),
                'imagen_mapa' => $this->imagen_mapa,
                'ofrecemos' => array_values($this->ofrecemos),
                'galeria' => array_values($this->galeria),
                'videos_youtube' => array_values($this->videos_youtube),
                'turismo' => array_values($this->turismo),
            ],
        ]);

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    public function render()
    {
        return view('livewire.admin.proyecto.proyecto-seccion-livewire');
    }
}
