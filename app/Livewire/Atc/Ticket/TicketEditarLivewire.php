<?php

namespace App\Livewire\Atc\Ticket;

use App\Models\EstadoTicket;
use App\Models\Archivo;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class TicketEditarLivewire extends Component
{
    use WithFileUploads;

    public $archivo;
    public $descripcion_archivo;
    public $archivos_existentes = [];

    public $ticket;

    public $asunto;
    public $descripcion;

    public $estados, $estado_ticket_id;

    public $historial = [];

    public $mapEstados = [];

    protected $rules = [
        'archivo' => 'required|file|max:51200|mimes:pdf,docx,xlsx,pptx',
        'descripcion_archivo' => 'nullable|string|max:2000',
    ];

    public function mount($id)
    {
        $this->ticket = Ticket::findOrFail($id);

        $this->estados     = EstadoTicket::all();
        $this->mapEstados  = $this->estados->pluck('nombre', 'id')->toArray();

        $this->estado_ticket_id = $this->ticket->estado_ticket_id;
        $this->asunto           = $this->ticket->asunto;
        $this->descripcion      = $this->ticket->descripcion;

        $this->historial = $this->ticket->historial()->latest()->get();
        $this->archivos_existentes = $this->ticket->archivos()->get();
    }

    public function store()
    {
        $old = $this->ticket->toArray();

        $data = [
            'estado_ticket_id' => $this->estado_ticket_id,
            'asunto'           => $this->asunto,
            'descripcion'      => $this->descripcion,
        ];

        $this->ticket->update($data);

        $cambios = [];

        foreach ($data as $campo => $valorNuevo) {

            $valorViejo = $old[$campo] ?? null;

            if ($valorNuevo != $valorViejo) {

                $nombreCampo = $this->nombreCampo($campo);
                $viejo       = $this->valorLegible($campo, $valorViejo);
                $nuevo       = $this->valorLegible($campo, $valorNuevo);

                $cambios[] = "$nombreCampo cambiado de '$viejo' a '$nuevo'";
            }
        }

        if (!empty($cambios)) {
            TicketHistorial::create([
                'ticket_id' => $this->ticket->id,
                'user_id'   => auth()->id(),
                'accion'    => 'Edición',
                'detalle'   => implode(" | ", $cambios),
            ]);
        }

        $this->historial = $this->ticket->historial()->latest()->get();

        $this->dispatch('alertaLivewire', "Actualizado");
    }

    protected function nombreCampo($campo)
    {
        return [
            'estado_ticket_id' => 'Estado',
            'asunto'           => 'Asunto',
            'descripcion'      => 'Descripción',
        ][$campo] ?? ucfirst(str_replace('_', ' ', $campo));
    }

    protected function valorLegible($campo, $valor)
    {
        if (!$valor) return '';

        return match ($campo) {
            'estado_ticket_id' => $this->mapEstados[$valor] ?? $valor,
            default            => $valor
        };
    }

    public function adjuntar()
    {
        $this->validate();

        $ruta = $this->archivo->store('archivos', 'public');
        $extension = $this->archivo->getClientOriginalExtension();

        Archivo::create([
            'archivable_type' => Ticket::class,
            'archivable_id'   => $this->ticket->id,
            'descripcion'     => $this->descripcion_archivo,
            'path'            => $ruta,
            'url'             => Storage::url($ruta),
            'extension'       => $extension,
        ]);

        TicketHistorial::create([
            'ticket_id' => $this->ticket->id,
            'user_id'   => auth()->id(),
            'accion'    => 'Adjuntar archivo',
            'detalle'   => "Se adjuntó el archivo '{$this->descripcion_archivo}' con extensión {$extension}",
        ]);

        $this->historial = $this->ticket->historial()->latest()->get();

        $this->reset(['archivo', 'descripcion_archivo']);

        $this->archivos_existentes = $this->ticket->archivos()->get();

        $this->dispatch('alertaLivewire', 'Creado');
    }

    public function cancelar()
    {
        $this->reset(['archivo', 'descripcion_archivo']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    #[On('eliminarArchivoOn')]
    public function eliminarArchivoOn($id)
    {
        $archivo = Archivo::find($id);

        if (!$archivo) {
            $this->dispatch('alertaLivewire', 'Error');
            return;
        }

        if (Storage::disk('public')->exists($archivo->path)) {
            Storage::disk('public')->delete($archivo->path);
        }

        $archivo->delete();

        TicketHistorial::create([
            'ticket_id' => $this->ticket->id,
            'user_id'   => auth()->id(),
            'accion'    => 'Eliminar archivo',
            'detalle'   => "Se eliminó el archivo '{$archivo->descripcion}' con extensión {$archivo->extension}",
        ]);

        $this->historial = $this->ticket->historial()->latest()->get();

        $this->archivos_existentes = $this->ticket->archivos()->get();

        $this->dispatch('alertaLivewire', 'Eliminado');
    }

    #[On('eliminarTicketOn')]
    public function eliminarTicketOn()
    {
        $ticket = $this->ticket->fresh();

        if ($ticket->estado_ticket_id != 1) {
            $this->dispatch('alertaLivewire', 'Solo se pueden eliminar tickets en estado ABIERTO.');
            return;
        }

        if ($ticket->derivados()->count() > 0) {
            $this->dispatch('alertaLivewire', 'Este ticket tiene derivaciones. No se puede eliminar.');
            return;
        }

        if ($ticket->archivos()->count() > 0) {
            $this->dispatch('alertaLivewire', 'Este ticket tiene archivos adjuntos. Primero elimínalos.');
            return;
        }


        TicketHistorial::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'accion'    => 'Eliminar ticket',
            'detalle'   => "Se eliminó el ticket con asunto '{$ticket->asunto}'",
        ]);

        $ticket->delete();

        return redirect()->route('admin.ticket.vista.todo');
    }

    public function render()
    {
        return view('livewire.atc.ticket.ticket-editar-livewire');
    }
}
