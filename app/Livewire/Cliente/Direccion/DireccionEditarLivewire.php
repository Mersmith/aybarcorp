<?php

namespace App\Livewire\Cliente\Direccion;

use App\Models\Direccion;
use App\Models\Region;
use App\Models\Distrito;
use App\Models\Provincia;
use Livewire\Component;

class DireccionEditarLivewire extends Component
{
    public $direccion_seleccionada;
    public $departamentos = [];
    public $provincias = [];
    public $distritos = [];
    public $region_id;
    public $provincia_id;
    public $distrito_id;
    public $recibe_nombres;
    public $recibe_celular;
    public $direccion;
    public $direccion_numero;
    public $codigo_postal;
    public $opcional;
    public $instrucciones;

    public $origen = '';

    protected function rules()
    {
        return [
            'recibe_nombres' => 'required',
            'recibe_celular' => 'required',
            'region_id' => 'required',
            'provincia_id' => 'required',
            'distrito_id' => 'required',
            'direccion' => 'required',
            'direccion_numero' => 'required',
            'codigo_postal' => 'required',
        ];
    }

    public function mount($direccionId, $origen)
    {
        $this->editDireccion($direccionId);
        $this->origen = $origen;
        $this->departamentos = Region::all();
    }

    public function editDireccion($direccionId)
    {
        $this->direccion_seleccionada = Direccion::find($direccionId);
        $this->recibe_nombres = $this->direccion_seleccionada->recibe_nombres;
        $this->recibe_celular = $this->direccion_seleccionada->recibe_celular;
        $this->direccion = $this->direccion_seleccionada->direccion;
        $this->direccion_numero = $this->direccion_seleccionada->direccion_numero;
        $this->codigo_postal = $this->direccion_seleccionada->codigo_postal;
        $this->opcional = $this->direccion_seleccionada->opcional;
        $this->instrucciones = $this->direccion_seleccionada->instrucciones;

        $this->region_id = $this->direccion_seleccionada->region_id;
        $this->loadProvincias();
        $this->provincia_id = $this->direccion_seleccionada->provincia_id;
        $this->loadDistritos();
        $this->distrito_id = $this->direccion_seleccionada->distrito_id;
    }

    public function updateDireccion()
    {
        $this->validate();

        $this->direccion_seleccionada->recibe_nombres = $this->recibe_nombres;
        $this->direccion_seleccionada->recibe_celular = $this->recibe_celular;
        $this->direccion_seleccionada->direccion = $this->direccion;
        $this->direccion_seleccionada->direccion_numero = $this->direccion_numero;
        $this->direccion_seleccionada->codigo_postal = $this->codigo_postal;
        $this->direccion_seleccionada->opcional = $this->opcional;
        $this->direccion_seleccionada->instrucciones = $this->instrucciones;

        $this->direccion_seleccionada->region_id = $this->region_id;
        $this->direccion_seleccionada->provincia_id = $this->provincia_id;
        $this->direccion_seleccionada->distrito_id = $this->distrito_id;

        $this->direccion_seleccionada->save();

        if ($this->origen == 'comprador-pagar') {
            $this->dispatch('emitCompradorPagarRefreshDirecciones');
        } else {
            $this->dispatch('emitCompradorRefreshDirecciones');
        }
        $this->resetValuesForm();
        $this->cerrarEditarModal();
    }

    public function updatedRegionId($value)
    {
        $this->provincia_id = null;
        $this->provincias = [];
        $this->distritos = [];
        $this->distrito_id = null;

        if ($value) {
            $this->loadProvincias();
        }
    }

    public function updatedProvinciaId($value)
    {
        $this->distritos = [];
        $this->distrito_id = null;

        if ($value) {
            $this->loadDistritos();
        }
    }

    public function loadProvincias()
    {
        if (!is_null($this->region_id)) {
            $this->provincias = Provincia::where('region_id', $this->region_id)->get();
        }
    }

    public function loadDistritos()
    {
        if (!is_null($this->provincia_id)) {
            $this->distritos = Distrito::where('provincia_id', $this->provincia_id)->get();
        }
    }

    public function cerrarEditarModal()
    {
        if ($this->origen == 'comprador-pagar') {
            $this->dispatch('emitCompradorPagarCerrarModalEditarDireccion');
        } else {
            $this->dispatch('emitCompradorCerrarModalEditarDireccion');
        }
    }

    public function resetValuesForm()
    {
        $this->reset([
            'recibe_nombres',
            'recibe_celular',
            'direccion',
            'direccion_numero',
            'codigo_postal',
            'region_id',
            'provincia_id',
            'distrito_id',
        ]);
    }

    public function render()
    {
        return view('livewire.cliente.direccion.direccion-editar-livewire');
    }
}
