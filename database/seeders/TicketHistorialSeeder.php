<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketHistorial;

class TicketHistorialSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = Ticket::all();
        $usuarios = User::all();

        $acciones = [
            'Cambio de estado',
            'Derivación',
            'Asignación',
            'Actualización de ticket',
            'Comentario del operador',
        ];

        foreach ($tickets as $ticket) {

            // Crear entre 1 y 3 historiales por ticket
            $cantidad = rand(1, 3);

            for ($i = 0; $i < $cantidad; $i++) {

                TicketHistorial::create([
                    'ticket_id' => $ticket->id,
                    'user_id'   => $usuarios->random()->id ?? null,

                    'accion'  => $acciones[array_rand($acciones)],
                    'detalle' => fake()->sentence(),

                    'created_at' => now()->subDays(rand(0, 10)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
