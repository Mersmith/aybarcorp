<?php

namespace App\Livewire\Atc\Ticket;

use App\Models\Area;
use App\Models\Canal;
use App\Models\User;
use App\Models\Cliente;
use App\Models\EstadoTicket;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class TicketCrearLivewire extends Component
{
    public $areas, $area_id = "";
    public $tipos_solicitudes = [], $tipo_solicitud_id = "";
    public $canales, $canal_id = "";
    public $clientes, $cliente_id = "";

    public $usuarios = [], $usuario_asignado_id = "";

    public $asunto_inicial;
    public $descripcion_inicial;

    public $existingCliente;
    public $dni;
    public $email;
    public $mostrar_form_email = false;
    public $cliente_encontrado = null;
    public $razones_sociales = [];
    public $razon_social_id = "";
    public $razon_social_select;
    public $lotes = null;
    public $lote_select = null;

    public $lote_id = "";
    public $lotes_agregados = [];

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
        $this->clientes = Cliente::all();
        $this->areas = Area::all();
        $this->canales = Canal::all();
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
            'cliente_id' => $this->cliente_id,
            'area_id' => $this->area_id,
            'tipo_solicitud_id' => $this->tipo_solicitud_id,
            'canal_id' => $this->canal_id,
            'estado_ticket_id' => $estadoAbiertoId,
            'usuario_asignado_id' => $this->usuario_asignado_id,
            'asunto_inicial' => $this->asunto_inicial,
            'descripcion_inicial' => $this->descripcion_inicial,
            'lotes' => $this->lotes_agregados,
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

    public function buscarCliente()
    {
        $response = Http::get("https://aybarcorp.com/api/slin/cliente/{$this->dni}");

        if ($response->failed() || empty($response->json())) {
            session()->flash('error', 'Intentelo más tarde, por favor.');
            return;
        }

        $this->cliente_encontrado = $response->json();
        $this->razones_sociales = $this->cliente_encontrado['empresas'];

        $this->existingCliente = Cliente::where('dni', $this->dni)->first();

        if (!$this->existingCliente) {
            $this->mostrar_form_email = true;
            session()->flash('info', 'Cliente nuevo. Ingrese un correo para registrarlo.');
        } else {
            $this->cliente_id = $this->existingCliente->user->id;
            $this->mostrar_form_email = false;
            session()->flash('success', 'Cliente encontrado en el sistema.');
        }
    }

    public function registrarClienteNuevo()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        $tempPassword = Str::random(8);

        $user = User::create([
            'name' => $this->cliente_encontrado['apellidos_nombres'],
            'email' => $this->email,
            'password' => Hash::make($tempPassword),
            'rol' => 'cliente',
            'activo' => true,
        ]);

        $cliente_nuevo = Cliente::create([
            'user_id' => $user->id,
            'dni' => $this->dni,
            'email' => $this->email,
        ]);

        Password::sendResetLink(['email' => $user->email]);

        session()->flash('success', "Cliente registrado. Contraseña temporal enviada al correo.");

        $this->cliente_id = $user->id;
        $this->existingCliente = $cliente_nuevo;
        $this->mostrar_form_email = false;
    }

    public function updatedRazonSocialId($value)
    {
        $this->lotes = [];

        if (empty($value)) {
            $this->razon_social_select = null;
            $this->lotes = null;
            return;
        }

        $this->razon_social_select = collect($this->razones_sociales)
            ->firstWhere('id_empresa', $value);

        if (!$this->razon_social_select) {
            $this->lotes = null;
            return;
        }

        $params = [
            "id_cliente" => $this->razon_social_select['codigo'],
            "id_empresa" => $this->razon_social_select['id_empresa'],
        ];

        $response = Http::get("https://aybarcorp.com/api/slin/lotes", $params);

        if ($response->failed() || empty($response->json())) {
            $this->lotes = [];
            session()->flash('error', 'Intentelo más tarde, por favor.');
            return;
        }

        $this->lotes = $response->json();

        $this->lote_select = null;
    }

    public function agregarLote()
    {
        if (empty($this->lote_id)) {
            return;
        }

        $lote = collect($this->lotes)->firstWhere('id_recaudo', $this->lote_id);

        if (!$lote) {
            return;
        }

        $existe = collect($this->lotes_agregados)->firstWhere('id_recaudo', $lote['id_recaudo']);

        if ($existe) {
            return;
        }

        $this->lotes_agregados[] = $lote;

        $this->lote_id = "";
    }

    public function quitarLote($id_recaudo)
    {
        $this->lotes_agregados = collect($this->lotes_agregados)
            ->reject(fn($l) => $l['id_recaudo'] == $id_recaudo)
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.atc.ticket.ticket-crear-livewire');
    }
}
