<?php

namespace App\Livewire\Atc\Cita;

use App\Models\Cita;
use App\Models\EstadoCita;
use App\Models\MotivoCita;
use App\Models\Sede;
use App\Models\Ticket;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Area;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admin.layout-admin')]
class CitaCrearLivewire extends Component
{
    public $ticket;
    public ?int $ticketId = null;

    public $gestores, $gestor_id = '';

    public $sedes, $sede_id = '';
    public $motivos, $motivo_cita_id = '';
    public $estados, $estado_cita_id = '';
    public $fecha;          // YYYY-MM-DD
    public $hora_inicio;    // HH:mm
    public $hora_fin;

    public $asunto_solicitud;
    public $descripcion_solicitud;

    protected int $duracionMinutos = 60;

    protected function rules()
    {
        return [
            'gestor_id' => 'required',
            'sede_id' => 'required',
            'motivo_cita_id' => 'required',
            'estado_cita_id' => 'required',

            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',

            'asunto_solicitud' => 'required|string|max:555',
            'descripcion_solicitud' => 'required|string|max:555',
        ];
    }

    protected $validationAttributes = [
        'gestor_id' => 'admin',
    ];

    public function mount($ticketId = null)
    {
        $this->ticketId = $ticketId;
        $this->ticket = Ticket::findOrFail($ticketId);

        $this->sedes = Sede::all();
        $this->motivos = MotivoCita::all();
        $this->estados = EstadoCita::all();

        if ($this->ticket->area_id) {
            $this->cargarDatosArea($this->ticket->area_id);
        }
    }

    public function cargarDatosArea($areaId)
    {
        $area = Area::find($areaId);

        if (!$area) {
            $this->gestores = collect();
            $this->gestor_id = null;
            return;
        }

        $this->gestores = $area->usuarios()
            ->where('activo', true)
            ->withPivot('is_principal')
            ->orderByDesc('area_user.is_principal')
            ->orderBy('users.name')
            ->get();

        $user = Auth::user();

        if ($this->gestores->contains('id', $user->id)) {
            $this->gestor_id = $user->id;
        } else {
            $principal = $this->gestores
                ->first(fn($u) => (bool) $u->pivot->is_principal);

            if ($principal) {
                $this->gestor_id = $principal->id;
            } else {
                $this->gestor_id = $this->gestores->first()?->id;
            }
        }
    }

    public function updatedHoraInicio($value)
    {
        if (!$this->fecha || !$value) {
            return;
        }

        $this->hora_fin = Carbon::createFromFormat(
            'Y-m-d H:i',
            "{$this->fecha} {$value}"
        )->addMinutes($this->duracionMinutos)
            ->format('H:i');
    }


    public function store()
    {
        $this->validate();

        $fechaInicio = Carbon::createFromFormat(
            'Y-m-d H:i',
            "{$this->fecha} {$this->hora_inicio}"
        );

        $fechaFin = Carbon::createFromFormat(
            'Y-m-d H:i',
            "{$this->fecha} {$this->hora_fin}"
        );

        $cita = Cita::create([
            'ticket_id' => $this->ticketId,

            'unidad_negocio_id' => $this->ticket->unidad_negocio_id,
            'proyecto_id' => $this->ticket->proyecto_id,
            'cliente_id' => $this->ticket->origen === 'slin'
                ? $this->ticket->cliente_id
                : null,

            'usuario_crea_id' => auth()->id(),
            'gestor_id' => $this->gestor_id,
            'sede_id' => $this->sede_id,
            'motivo_cita_id' => $this->motivo_cita_id,
            'estado_cita_id' => $this->estado_cita_id,

            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,

            'asunto_solicitud' => $this->asunto_solicitud,
            'descripcion_solicitud' => $this->descripcion_solicitud,

            'dni' => $this->ticket->dni,
            'nombres' => $this->ticket->nombres,
            'origen' => $this->ticket->origen,
        ]);

        $this->dispatch('alertaLivewire', [
            'title' => 'Creado',
            'text' => 'Se guardó correctamente.',
        ]);

        return redirect()->route('admin.cita.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.cita.cita-crear-livewire');
    }
}
