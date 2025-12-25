<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Area;
use App\Models\User;
use App\Models\TicketDerivado;

class TicketDerivadoSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = Ticket::all();
        $areas   = Area::all();
        $users   = User::all();

        foreach ($tickets as $ticket) {

            // 50% de tickets derivados
            if (rand(0, 1) === 0) {
                continue;
            }

            // Se eligen dos áreas diferentes
            $de = $areas->random();
            $a  = $areas->except($de->id)->random() ?? $de;

            TicketDerivado::create([
                'ticket_id'          => $ticket->id,
                'de_area_id'         => $de->id,
                'a_area_id'          => $a->id,

                'usuario_deriva_id'  => $users->random()->id ?? null,
                'usuario_recibe_id'  => $users->random()->id ?? null,

                'motivo' => fake()->sentence(8),

                'created_at' => now()->subDays(rand(0, 10)),
                'updated_at' => now(),
            ]);
        }
    }
}
