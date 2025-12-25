<?php

namespace App\Livewire\Atc\Ticket;

use App\Models\Area;
use App\Models\EstadoTicket;
use App\Models\Ticket;
use App\Models\TicketDerivado;
use App\Models\TicketHistorial;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class TicketDerivadoLivewire extends Component
{
    public $ticket;

    public $areas;
    public $usuarios = [];

    public $a_area_id = "";
    public $usuario_recibe_id = "";
    public $motivo;

    public $mapAreas = [];
    public $mapEstados = [];
    public $mapUsuarios = [];

    public $derivaciones = [];
    public $historial = [];

    protected function rules()
    {
        return [
            'a_area_id' => 'required',
            'usuario_recibe_id' => 'required',
            'motivo' => 'required|string|max:2000',
        ];
    }

    protected function nombreCampo($campo)
    {
        return [
            'area_id'             => 'Área',
            'usuario_asignado_id' => 'Usuario asignado',
            'estado_ticket_id'    => 'Estado',
        ][$campo] ?? ucfirst(str_replace('_', ' ', $campo));
    }

    protected function valorLegible($campo, $valor)
    {
        if (!$valor) return 'Sin asignar';

        return match ($campo) {
            'area_id'             => $this->mapAreas[$valor] ?? $valor,
            'usuario_asignado_id' => $this->nombreUsuario($valor),
            'estado_ticket_id'    => $this->mapEstados[$valor] ?? $valor,
            default               => $valor
        };
    }

    protected function nombreUsuario($id)
    {
        if (isset($this->mapUsuarios[$id])) {
            return $this->mapUsuarios[$id];
        }

        $user = User::find($id);
        $this->mapUsuarios[$id] = $user?->name ?? $id;

        return $this->mapUsuarios[$id];
    }

    public function mount($id)
    {
        $this->ticket = Ticket::findOrFail($id);

        $this->areas = Area::all();
        $this->mapAreas = $this->areas->pluck('nombre', 'id')->toArray();

        $estados = EstadoTicket::all();
        $this->mapEstados = $estados->pluck('nombre', 'id')->toArray();

        $this->derivaciones = $this->ticket->derivados()->latest()->get();
        $this->historial = $this->ticket->historial()->latest()->get();
    }

    public function updatedAAreaId($value)
    {
        $area = Area::find($value);

        $this->usuarios = $area
            ? $area->usuarios()->where('activo', true)->get()
            : [];

        $this->usuario_recibe_id = "";
    }

    public function derivar()
    {
        $this->validate();

        $old = $this->ticket->toArray();
        $deAreaId = $this->ticket->area_id;

        TicketDerivado::create([
            'ticket_id'         => $this->ticket->id,
            'de_area_id'        => $deAreaId,
            'a_area_id'         => $this->a_area_id,
            'usuario_deriva_id' => auth()->id(),
            'usuario_recibe_id' => $this->usuario_recibe_id,
            'motivo'            => $this->motivo,
        ]);

        $this->ticket->update([
            'area_id'             => $this->a_area_id,
            'usuario_asignado_id' => $this->usuario_recibe_id,
        ]);

        $new = $this->ticket->fresh()->toArray();

        $cambios = [];
        $ignorar = ['id', 'created_at', 'updated_at', 'deleted_at'];

        foreach ($new as $campo => $valorNuevo) {

            if (in_array($campo, $ignorar)) continue;

            $valorViejo = $old[$campo] ?? null;

            if ($valorNuevo != $valorViejo) {

                $nombreCampo = $this->nombreCampo($campo);
                $viejo = $this->valorLegible($campo, $valorViejo);
                $nuevo = $this->valorLegible($campo, $valorNuevo);

                $cambios[] = "$nombreCampo cambiado de '$viejo' a '$nuevo'";
            }
        }

        if ($this->motivo) {
            $cambios[] = "Motivo: {$this->motivo}";
        }

        TicketHistorial::create([
            'ticket_id' => $this->ticket->id,
            'user_id'   => auth()->id(),
            'accion'    => 'Derivación',
            'detalle'   => implode(" | ", $cambios),
        ]);

        $this->historial = $this->ticket->historial()->latest()->get();
        $this->derivaciones = $this->ticket->derivados()->latest()->get();

        $this->a_area_id = "";
        $this->usuario_recibe_id = "";
        $this->motivo = null;

        $this->dispatch('alertaLivewire', "Creado");
    }

    public function render()
    {
        return view('livewire.atc.ticket.ticket-derivado-livewire');
    }
}
