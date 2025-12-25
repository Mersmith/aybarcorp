<?php

namespace App\Livewire\Atc\Cita;

use App\Models\Cita;
use App\Models\EstadoCita;
use App\Models\MotivoCita;
use App\Models\Sede;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class CitaCrearLivewire extends Component
{
    public $usuarios_admin, $usuario_solicita_id = '';

    public $usuarios_cliente = [], $usuario_recibe_id = '';
    public $buscar_cliente = '';
    public $select_cliente;

    public $sedes, $sede_id = '';
    public $motivos, $motivo_cita_id = '';
    public $estados, $estado_cita_id = '';
    public $fecha_inicio;
    public $fecha_fin;

    public $asunto_solicitud;
    public $descripcion_solicitud;

    protected function rules()
    {
        return [
            'usuario_solicita_id' => 'required',
            'usuario_recibe_id' => 'required',
            'sede_id' => 'required',
            'motivo_cita_id' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'estado_cita_id' => 'required',
            'asunto_solicitud' => 'required|string|max:555',
            'descripcion_solicitud' => 'required|string|max:555',
        ];
    }

    protected $validationAttributes = [
        'usuario_solicita_id' => 'admin',
        'usuario_recibe_id' => 'cliente',
    ];

    public function mount()
    {
        $this->sedes = Sede::all();
        $this->motivos = MotivoCita::all();
        $this->estados = EstadoCita::all();
        $this->usuarios_admin = User::where('rol', 'admin')->get();
    }

    public function seleccionarCliente($id)
    {
        $this->usuario_recibe_id = $id;

        $this->select_cliente = User::find($id);
    }

    public function store()
    {
        $this->validate();

        $cita = Cita::create([
            'usuario_solicita_id' => $this->usuario_solicita_id,
            'usuario_recibe_id' => $this->usuario_recibe_id,
            'sede_id' => $this->sede_id,
            'motivo_cita_id' => $this->motivo_cita_id,
            'estado_cita_id' => $this->estado_cita_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'asunto_solicitud' => $this->asunto_solicitud,
            'descripcion_solicitud' => $this->descripcion_solicitud,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.cita.vista.todo');
    }

    public function render()
    {
        $this->usuarios_cliente = User::where('rol', 'cliente')
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->buscar_cliente . '%')
                    ->orWhere('email', 'like', '%' . $this->buscar_cliente . '%');
            })
            ->limit(5)
            ->get();

        return view('livewire.atc.cita.cita-crear-livewire');
    }
}
