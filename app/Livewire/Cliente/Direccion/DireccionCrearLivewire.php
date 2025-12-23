<?php

namespace App\Livewire\Cliente\Direccion;

use App\Models\Direccion;
use App\Models\Distrito;
use App\Models\Provincia;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DireccionCrearLivewire extends Component
{
    public $departamentos;
    public $provincias = [];
    public $distritos = [];
    public $region_id = '';
    public $provincia_id = '';
    public $distrito_id = '';
    public $recibe_nombres = '';
    public $recibe_celular = '';
    public $direccion = '';
    public $direccion_numero = '';
    public $codigo_postal = '';
    public $opcional = '';
    public $instrucciones = '';

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

    public function mount($origen)
    {
        $this->origen = $origen;
        $this->departamentos = Region::all();
    }

    public function createDireccion()
    {
        $this->validate();

        $direccion = new Direccion();
        $direccion->user_id = Auth::user()->id;
        $direccion->recibe_nombres = $this->recibe_nombres;
        $direccion->recibe_celular = $this->recibe_celular;
        $direccion->direccion = $this->direccion;
        $direccion->direccion_numero = $this->direccion_numero;
        $direccion->codigo_postal = $this->codigo_postal;
        $direccion->region_id = $this->region_id;
        $direccion->provincia_id = $this->provincia_id;
        $direccion->distrito_id = $this->distrito_id;
        $direccion->opcional = $this->opcional;
        $direccion->instrucciones = $this->instrucciones;

        $direccion->save();

        if ($this->origen == 'comprador-pagar') {
            $this->dispatch('emitCompradorPagarRefreshDirecciones');
        } else {
            $this->dispatch('emitCompradorRefreshDirecciones');
        }
        $this->resetValuesForm();
        $this->cerrarCrearModal();
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

    public function cerrarCrearModal()
    {
        if ($this->origen == 'comprador-pagar') {
            $this->dispatch('emitCompradorPagarCerrarModalCrearDireccion');
        } else {
            $this->dispatch('emitCompradorCerrarModalCrearDireccion');
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
        return view('livewire.cliente.direccion.direccion-crear-livewire');
    }
}
