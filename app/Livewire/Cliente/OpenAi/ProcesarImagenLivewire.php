<?php

namespace App\Livewire\Cliente\OpenAi;

use App\Models\EvidenciaPago;
use App\Models\Proyecto;
use App\Models\UnidadNegocio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use OpenAI;

class ProcesarImagenLivewire extends Component
{
    use WithFileUploads;

    public $lote;
    public $cuota;

    public $imagen;
    public $datos = [];
    public $procesando = false;

    public $empresas, $unidad_negocio_id = '';
    public $proyectos = [], $proyecto_id = '';

    protected function rules()
    {
        return [
            'imagen' => 'required|image|max:4096',
            'datos.numero' => 'required',
            'datos.banco' => 'required',
            'datos.monto' => 'required',
            'datos.fecha' => 'required',
            'unidad_negocio_id' => 'required',
            'proyecto_id' => 'required',
        ];
    }

    protected $validationAttributes = [
        'unidad_negocio_id' => 'Razón Social',
        'proyecto_id' => 'Proyecto',
        'datos.numero' => 'N° operación',
        'datos.banco' => 'Banco',
        'datos.monto' => 'Monto',
        'datos.fecha' => 'Fecha',
    ];

    public function mount($cuota, $lote)
    {
        $this->cuota = $cuota;
        $this->lote = $lote;

        $this->empresas = UnidadNegocio::all();
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

    public function procesarImagen()
    {
        $this->validate([
            'imagen' => 'required|image|max:4096',
        ]);

        $this->procesando = true;

        try {
            // Convertir imagen a base64
            $imageData = base64_encode(file_get_contents($this->imagen->getRealPath()));

            $client = OpenAI::client(config('services.openai.key'));

            // --- PETICIÓN CORRECTA ---
            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                "type" => "text",
                                "text" => "Extrae los datos EXACTOS del comprobante BCP.
Devuelve únicamente un JSON válido con esta estructura:

{
  \"numero_operacion\": \"\",
  \"banco\": \"\",
  \"monto\": \"\",
  \"fecha\": \"AAAA-MM-DD\"
}

Muy importante:
- La fecha SIEMPRE debe estar en formato AAAA-MM-DD.

NO agregues explicación ni texto adicional. Solo JSON.",
                            ],
                            [
                                "type" => "image_url",
                                "image_url" => [
                                    "url" => "data:image/jpeg;base64,{$imageData}",
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            // --- PROCESAR RESPUESTA ---
            $content = $response->choices[0]->message->content;

            $texto = '';

            // Si devuelve blocks
            if (is_array($content)) {
                foreach ($content as $block) {
                    if (($block['type'] ?? null) === 'text') {
                        $texto .= $block['text'];
                    }
                }
            } else {
                $texto = $content;
            }

            // Limpiar ```json
            $texto = trim(preg_replace('/```json|```/', '', $texto));

            // Decodificar JSON
            $data = json_decode($texto, true);

            if (!$data) {
                session()->flash('error', 'No se pudo extraer la información correctamente.');
                $this->procesando = false;
                return;
            }

            if (!$data['numero_operacion']) {
                session()->flash('error', 'No se detectaron campos válidos');
                $this->procesando = false;
                return;
            }

            // Asignar datos
            $this->datos = [
                'numero' => $data['numero_operacion'] ?? null,
                'banco' => $data['banco'] ?? null,
                'monto' => $data['monto'] ?? null,
                'fecha' => $data['fecha'] ?? null,
            ];
        } catch (\Exception $e) {
            session()->flash('error', '❌ Error: ' . $e->getMessage());
        }

        $this->procesando = false;
    }

    public function eliminarImagen()
    {
        $this->reset(['imagen', 'datos']);
    }

    public function guardar()
    {
        $this->validate();

        // Guardar archivo
        $ruta = $this->imagen->store('evidencias', 'public');
        $url = Storage::url($ruta);
        $extension = $this->imagen->getClientOriginalExtension();

        $fecha = $this->datos['fecha'] ?? null;

        $monto = null;
        if (!empty($this->datos['monto'])) {
            $monto = preg_replace('/[^0-9.]/', '', $this->datos['monto']);
        }

        EvidenciaPago::create([
            'unidad_negocio_id' => $this->unidad_negocio_id,
            'proyecto_id' => $this->proyecto_id,
            'path' => $ruta,
            'url' => $url,
            'extension' => $extension,
            'numero_operacion' => $this->datos["numero"] ?? null,
            'banco' => $this->datos["banco"] ?? null,
            'monto' => $monto,
            'fecha' => $fecha,
            'cliente_id' => Auth::user()->id,

            'codigo_cliente' => $this->lote["id_cliente"] ?? null,
            'razon_social' => $this->lote["razon_social"] ?? null,
            'nombre_proyecto' => $this->lote["descripcion"] ?? null,
            'etapa' => $this->lote["id_etapa"] ?? null,
            'manzana' => $this->lote["id_manzana"] ?? null,
            'lote' => $this->lote["id_lote"] ?? null,
            'codigo_cuota' => $this->cuota["idCuota"] ?? null,
            'numero_cuota' => $this->cuota["NroCuota"] ?? null,
            'transaccion_id' => $this->cuota["IdTransaccion"] ?? null,
            'lote_completo' => $this->lote['id_proyecto'] . '' . $this->lote['id_etapa'] . '-' . $this->lote['id_manzana'] . '-' . $this->lote['id_lote'],
        ]);

        session()->flash('success', 'Comprobante guardado correctamente 👍');
        $this->reset(['imagen', 'datos', 'unidad_negocio_id', 'proyecto_id']);

        //$this->dispatch('cerrarModalEvidenciaPagoOn');
        $this->dispatch('actualizarCronograma');
    }

    public function render()
    {
        return view('livewire.cliente.open-ai.procesar-imagen-livewire');
    }
}
