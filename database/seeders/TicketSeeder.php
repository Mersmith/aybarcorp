<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Area;
use App\Models\TipoSolicitud;
use App\Models\Canal;
use App\Models\EstadoTicket;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = User::where('rol', 'cliente')->pluck('id')->toArray();
        $admins   = User::where('rol', 'admin')->pluck('id')->toArray();

        $areas = Area::pluck('id')->toArray();
        $canales = Canal::pluck('id')->toArray();
        $estados = EstadoTicket::pluck('id')->toArray();

        $asuntos = [
            'No puedo acceder a mi cuenta',
            'Problema con mi pedido',
            'Consulta de facturación',
            'Error en el sistema',
            'No puedo actualizar mis datos',
            'Necesito soporte técnico',
        ];

        $descripciones = [
            'Ocurre desde ayer.',
            'Ya intenté varias veces sin éxito.',
            'Adjunto captura del error.',
            'Agradezco su pronta respuesta.',
            'No sé cómo solucionarlo.',
        ];

        for ($i = 0; $i < 50; $i++) {

            $areaId = fake()->randomElement($areas);

            $tipos = TipoSolicitud::whereHas('areas', function ($q) use ($areaId) {
                $q->where('area_id', $areaId);
            })->pluck('id')->toArray();

            $tipoId = $tipos ? fake()->randomElement($tipos) : TipoSolicitud::inRandomOrder()->value('id');

            Ticket::create([
                'cliente_id'          => fake()->randomElement($clientes),
                'area_id'             => $areaId,
                'tipo_solicitud_id'   => $tipoId,
                'canal_id'            => fake()->randomElement($canales),
                'estado_ticket_id'    => fake()->randomElement($estados),

                'prioridad_ticket_id'           => fake()->randomElement([1, 2, 3]),

                'usuario_asignado_id' => fake()->randomElement($admins),

                'asunto_inicial'      => fake()->randomElement($asuntos),
                'descripcion_inicial' => fake()->randomElement($descripciones),

                'asunto'              => fake()->boolean(40) ? fake()->sentence() : null,
                'descripcion'         => fake()->boolean(40) ? fake()->paragraph() : null,

                'lotes' => [
                    [
                        "razon_social" => fake()->company(),
                        "descripcion"  => fake()->sentence(4),
                        "id_manzana"   => rand(1, 50),
                        "id_lote"      => rand(1, 200),
                    ]
                ],

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
