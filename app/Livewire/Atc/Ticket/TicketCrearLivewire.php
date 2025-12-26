<?php

namespace App\Livewire\Atc\Ticket;

use App\Models\Area;
use App\Models\Canal;
use App\Models\Cliente;
use App\Models\EstadoTicket;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use Livewire\Attributes\Layout;
use App\Services\ConsultaClienteService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class TicketCrearLivewire extends Component
{
    public $areas, $area_id = "";
    public $tipos_solicitudes = [], $tipo_solicitud_id = "";
    public $canales, $canal_id = "";
    public $cliente, $cliente_id = "", $origen = "";

    public $usuarios = [], $usuario_asignado_id = "";

    public $asunto_inicial;
    public $descripcion_inicial;

    public $dni;

    public $lote_id = "";
    public $lotes_agregados = [];

    public Collection $informaciones;

    protected function rules()
    {
        return [
            'cliente_id' => 'required',
            'area_id' => 'required',
            'tipo_solicitud_id' => 'required',
            'canal_id' => 'required',
            'usuario_asignado_id' => 'required',
            'asunto_inicial' => 'required|string|max:255',
            'descripcion_inicial' => 'required|string|max:555',
        ];
    }

    public function mount()
    {
        $this->areas = Area::all();
        $this->canales = Canal::all();

        $this->informaciones = collect();
    }

    public function updatedAreaId($value)
    {
        $area = Area::find($value);

        $this->tipos_solicitudes = $area ? $area->tipos()->where('activo', true)->get() : [];
        $this->usuarios = $area ? $area->usuarios()->where('activo', true)->get() : [];

        $this->tipo_solicitud_id = "";
        $this->usuario_asignado_id = "";
    }

    public function store()
    {
        $this->validate();

        $estadoAbiertoId = EstadoTicket::where('nombre', 'Abierto')->value('id');

        $ticket = Ticket::create([
            'cliente_id' => $this->origen === 'slin' ? $this->cliente_id : null,
            'area_id' => $this->area_id,
            'tipo_solicitud_id' => $this->tipo_solicitud_id,
            'canal_id' => $this->canal_id,
            'estado_ticket_id' => $estadoAbiertoId,
            'usuario_asignado_id' => $this->usuario_asignado_id,
            'asunto_inicial' => $this->asunto_inicial,
            'descripcion_inicial' => $this->descripcion_inicial,
            'lotes' => $this->lotes_agregados,
            'dni' => $this->cliente->dni,
            'nombres' => $this->cliente->nombre,
            'origen' => $this->origen,
        ]);

        TicketHistorial::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'accion' => 'Creación',
            'detalle' => 'Ticket creado con estado: Abierto',
        ]);

        $this->dispatch('alertaLivewire', "Creado");

        return redirect()->route('admin.ticket.vista.todo');
    }

    public function buscarCliente(ConsultaClienteService $service)
    {
        $this->validate([
            'dni' => 'required',
        ]);

        $resultado = $service->consultar($this->dni);

        switch ($resultado['estado']) {

            case 'ok':
                session()->flash('success', $resultado['mensaje']);
                $this->informaciones = $resultado['data'];

                if ($resultado['origen'] === 'antiguo') {
                    $this->cliente = DB::table('clientes_2')->where('dni', $this->dni)->first();
                    $this->cliente_id = $this->cliente->id;
                    $this->origen = "antiguo";
                } elseif ($resultado['origen'] === 'slin') {
                    $this->cliente = Cliente::where('dni', $this->dni)->first();
                    if (!$this->cliente) {
                        session()->flash('info', 'Debes crear la cuenta del cliente.');
                    } else {
                        $this->cliente_id = $this->cliente->user->id;
                        session()->flash('success', 'Cliente creado desde su portal.');
                    }
                    $this->origen = "slin";
                }

                break;

            case 'cliente_sin_lotes':
                session()->flash('info', $resultado['mensaje']);
                $this->informaciones = collect();

                $this->cliente = Cliente::where('dni', $this->dni)->first();

                if (!$this->cliente) {
                    session()->flash('info', 'Debes crear la cuenta del cliente.');
                } else {
                    $this->cliente_id = $this->cliente->user->id;
                    session()->flash('success', 'Cliente encontrado en el sistema.');
                }

                $this->origen = "slin";

                break;

            case 'no_cliente':
                session()->flash('error', $resultado['mensaje']);
                break;

            case 'error':
                session()->flash('error', $resultado['mensaje']);
                break;
        }
    }

    public function agregarLote()
    {
        if (! $this->lote_id) {
            return;
        }

        // Buscar el lote por ID (el mismo que viene del select)
        $lote = $this->informaciones->firstWhere('id', $this->lote_id);

        if (! $lote) {
            return;
        }

        // Evitar duplicados por ID
        $existe = collect($this->lotes_agregados)
            ->firstWhere('id', $lote->id);

        if ($existe) {
            return;
        }

        $this->lotes_agregados[] = [
            'id'           => $lote->id,
            'razon_social' => $lote->razon_social,
            'proyecto'     => $lote->proyecto,
            'numero_lote'   => $lote->numero_lote,
        ];

        // Limpiar select
        $this->lote_id = "";
    }

    public function quitarLote($id)
    {
        $this->lotes_agregados = collect($this->lotes_agregados)
            ->reject(fn($l) => $l['id'] == $id)
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.atc.ticket.ticket-crear-livewire');
    }
}
