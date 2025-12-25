<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cita;
use App\Models\User;
use App\Models\Sede;
use App\Models\MotivoCita;

class CitaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('rol', 'admin')->first();
        $clientes = User::where('rol', 'cliente')->get();
        $sedes = Sede::all();
        $motivos = MotivoCita::where('activo', true)->get();

        if (!$admin || $clientes->isEmpty() || $sedes->isEmpty() || $motivos->isEmpty()) {
            return;
        }

        $estados = [1, 2, 3, 4];
        $duraciones = [30, 45, 60, 90];

        for ($i = 0; $i < 50; $i++) {

            $cliente = $clientes->random();
            $sede = $sedes->random();
            $motivo = $motivos->random();

            // Fecha random
            $start = fake()->dateTimeBetween('2025-09-01', '2025-12-31');

            // Hora random entre 8 AM – 6 PM
            $start->setTime(fake()->numberBetween(8, 17), fake()->numberBetween(0, 59));

            $duracion = $duraciones[array_rand($duraciones)];
            $end = (clone $start)->modify("+{$duracion} minutes");

            Cita::create([
                'usuario_solicita_id' => $admin->id,
                'usuario_recibe_id'   => $cliente->id,
                'sede_id'             => $sede->id,
                'motivo_cita_id'      => $motivo->id,
                'fecha_inicio'            => $start,
                'fecha_fin'              => $end,
                'estado_cita_id'              => $estados[array_rand($estados)],
            ]);
        }

        // Crear 20 citas SOLO para HOY con horarios distintos
        $hoy = now()->startOfDay();
        $horaActual = $hoy->copy()->setTime(8, 0); // empiezan desde las 8:00 AM

        for ($i = 0; $i < 20; $i++) {

            $cliente = $clientes->random();
            $sede = $sedes->random();
            $motivo = $motivos->random();
            $duracion = $duraciones[array_rand($duraciones)];

            // generar start/end
            $start = $horaActual->copy();
            $end = $start->copy()->addMinutes($duracion);

            // evitar que pase de las 6 PM
            if ($start->hour >= 18) {
                break;
            }

            Cita::create([
                'usuario_solicita_id' => $admin->id,
                'usuario_recibe_id'   => $cliente->id,
                'sede_id'             => $sede->id,
                'motivo_cita_id'      => $motivo->id,
                'fecha_inicio'            => $start,
                'fecha_fin'              => $end,
                'estado_cita_id'              => 2,
            ]);

            // mover horaActual para próxima cita
            $horaActual = $end->copy()->addMinutes(5); // 5 minutos entre citas
        }
    }
}
