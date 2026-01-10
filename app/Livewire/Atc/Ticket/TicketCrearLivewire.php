<?php

namespace App\Livewire\Atc\Ticket;

use App\Mail\TicketCreadoMail;
use App\Models\Area;
use App\Models\Canal;
use App\Models\Cliente;
use App\Models\EstadoTicket;
use App\Models\Proyecto;
use App\Models\SubTipoSolicitud;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use App\Models\UnidadNegocio;
use App\Services\ConsultaClienteService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class TicketCrearLivewire extends Component
{

    public $ticketPadre;
    public ?int $ticketPadreId = null;

    public ?Area $area_seleccionada = null;

    public $areas, $area_id = "";
    public $tipos_solicitudes = [], $tipo_solicitud_id = "";
    public $sub_tipos_solicitudes = [], $sub_tipo_solicitud_id = "";
    public $canales, $canal_id = "";
    public $cliente, $cliente_id = "", $origen = "";

    public $gestores = [], $gestor_id = "";

    public $asunto_inicial;
    public $descripcion_inicial;

    public $dni;

    public $lote_id = "";
    public $lotes_agregados = [];

    public $empresas, $unidad_negocio_id = '';
    public $proyectos = [], $proyecto_id = '';

    public Collection $informaciones;

    protected function rules()
    {
        return [
            'unidad_negocio_id' => 'required',
            'proyecto_id' => 'required',
            'cliente_id' => 'required',
            'area_id' => 'required',
            'tipo_solicitud_id' => 'required',
            'sub_tipo_solicitud_id' => 'required',
            'canal_id' => 'required',
            'gestor_id' => 'required',
            'asunto_inicial' => 'required|string|max:255',
            'descripcion_inicial' => 'required|string|max:555',
        ];
    }

    public function mount($ticketPadre = null)
    {
        if ($ticketPadre) {
            $this->ticketPadreId = $ticketPadre;
            $this->ticketPadre = Ticket::findOrFail($ticketPadre);
            $this->unidad_negocio_id = $this->ticketPadre->unidad_negocio_id;
            $this->proyecto_id = $this->ticketPadre->proyecto_id;
            $this->loadProyectos();
            $this->canal_id = $this->ticketPadre->canal_id;
            $this->cliente_id = $this->ticketPadre->nombres;
            $this->dni = $this->ticketPadre->dni;
            //$this->nombres = $this->ticketPadre->nombres;
            $this->origen = $this->ticketPadre->origen;
        }

        $user = Auth::user();

        if ($user->areas()->exists()) {
            $this->area_id = $user->areas()->orderBy('area_user.created_at')->value('areas.id');
        } else {
            $this->area_id = Area::orderBy('id')->value('id');
        }

        $this->areas = Area::all();
        $this->canales = Canal::all();
        $this->empresas = UnidadNegocio::all();
        $this->informaciones = collect();

        if ($this->area_id) {
            $this->cargarDatosArea($this->area_id);
        }
    }

    public function updatedUnidadNegocioId($value)
    {
        $this->proyecto_id = '';

        if ($value) {
            $this->loadProyectos();
        }
    }

    public function loadProyectos()
    {
        if (!is_null($this->unidad_negocio_id)) {
            $this->proyectos = Proyecto::where('unidad_negocio_id', $this->unidad_negocio_id)->get();
        }
    }

    public function cargarDatosArea($areaId)
    {
        $area = Area::find($areaId);

        if (!$area) {
            $this->area_seleccionada = null;
            $this->tipos_solicitudes = collect();
            $this->gestores = collect();
            $this->gestor_id = null;
            $this->tipo_solicitud_id = null;
            return;
        }

        $this->area_seleccionada = $area;

        $this->tipos_solicitudes = $area->tipos()
            ->where('activo', true)
            ->get();

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

        $this->tipo_solicitud_id = '';
    }

    public function updatedAreaId($value)
    {
        $this->cargarDatosArea($value);
    }

    public function updatedTipoSolicitudId($value)
    {
        $this->sub_tipo_solicitud_id = '';

        if ($value) {
            $this->loadSubTipoSolicitudes();
        }
    }

    public function loadSubTipoSolicitudes()
    {
        if (!is_null($this->tipo_solicitud_id)) {
            $this->sub_tipos_solicitudes = SubTipoSolicitud::where('tipo_solicitud_id', $this->tipo_solicitud_id)->get();
        }
    }

    public function store()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('alertaLivewire', ['title' => 'Advertencia', 'text' => 'Verifique los errores de los campos resaltados.']);
            throw $e;
        }

        $estadoAbiertoId = EstadoTicket::orderBy('id')->value('id');

        $ticket = Ticket::create([
            'ticket_padre_id' => $this->ticketPadreId,

            'unidad_negocio_id' => $this->unidad_negocio_id,
            'proyecto_id' => $this->proyecto_id,
            'cliente_id' => $this->origen === 'slin' ? $this->cliente_id : null,

            'area_id' => $this->area_id,
            'tipo_solicitud_id' => $this->tipo_solicitud_id,
            'sub_tipo_solicitud_id' => $this->sub_tipo_solicitud_id,
            'canal_id' => $this->canal_id,
            'estado_ticket_id' => $estadoAbiertoId,
            'gestor_id' => $this->gestor_id,
            'asunto_inicial' => $this->asunto_inicial,
            'descripcion_inicial' => $this->descripcion_inicial,
            'lotes' => $this->lotes_agregados,

            'dni' => $this->ticketPadre ? $this->ticketPadre->dni : $this->cliente->dni,
            'nombres' => $this->ticketPadre ? $this->ticketPadre->nombres : $this->cliente->nombre,
            'origen' => $this->origen,
        ]);

        TicketHistorial::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'accion' => 'Creación',
            'detalle' => 'Ticket creado con estado: Abierto',
        ]);

        $correoEnviado = false;

        if ($this->area_seleccionada?->email_buzon) {
            Mail::to($this->area_seleccionada->email_buzon)
                ->send(new TicketCreadoMail($ticket));

            $correoEnviado = true;
        }

        $mensaje = $correoEnviado
        ? 'Ticket creado y correo enviado correctamente.'
        : 'Ticket creado correctamente.';

        $this->dispatch('alertaLivewire', [
            'title' => 'Creado',
            'text' => $mensaje,
        ]);

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
        if (!$this->lote_id) {
            return;
        }

        // Buscar el lote por ID (el mismo que viene del select)
        $lote = $this->informaciones->firstWhere('id', $this->lote_id);

        if (!$lote) {
            return;
        }

        // Evitar duplicados por ID
        $existe = collect($this->lotes_agregados)
            ->firstWhere('id', $lote->id);

        if ($existe) {
            return;
        }

        $this->lotes_agregados[] = [
            'id' => $lote->id,
            'razon_social' => $lote->razon_social,
            'proyecto' => $lote->proyecto,
            'numero_lote' => $lote->numero_lote,
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
