<?php

namespace App\Livewire\Atc\Cita;

use App\Models\Cita;
use App\Models\EstadoCita;
use App\Models\MotivoCita;
use App\Models\Sede;
use App\Models\Ticket;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class CitaCrearLivewire extends Component
{
    public $ticket;
    public ?int $ticketId = null;

    public $usuarios_admin, $usuario_crea_id = '';

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
            'usuario_crea_id' => 'required',
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
        'usuario_crea_id' => 'admin',
    ];

    public function mount($ticketId = null)
    {
        $this->ticketId = $ticketId;
        $this->ticket = Ticket::findOrFail($ticketId);

        $this->sedes = Sede::all();
        $this->motivos = MotivoCita::all();
        $this->estados = EstadoCita::all();
        $this->usuarios_admin = User::role('asesor-atc')
            ->where('rol', 'admin')
            ->get();
    }

    public function store()
    {
        $this->validate();

        $cita = Cita::create([
            'ticket_id' => $this->ticketId,

            'unidad_negocio_id' => $this->ticket->unidad_negocio_id,
            'proyecto_id' => $this->ticket->proyecto_id,
            'cliente_id' => $this->ticket->origen === 'slin'
            ? $this->ticket->cliente_id
            : null,

            'usuario_crea_id' => $this->usuario_crea_id,
            'sede_id' => $this->sede_id,
            'motivo_cita_id' => $this->motivo_cita_id,
            'estado_cita_id' => $this->estado_cita_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'asunto_solicitud' => $this->asunto_solicitud,
            'descripcion_solicitud' => $this->descripcion_solicitud,

            'dni' => $this->ticket->dni,
            'nombres' => $this->ticket->nombres,
            'origen' => $this->ticket->origen,
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.cita.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.cita.cita-crear-livewire');
    }
}
