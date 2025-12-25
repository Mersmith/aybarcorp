@php
$fecha = $fechaActual->toDateString();
$items = collect($eventos)->where('date', $fecha);

// Horario de 6:00am a 10:00pm
$horas = collect();
for ($h = 6; $h <= 22; $h++) { $horas->push(sprintf('%02d:00', $h));
    }
    @endphp

    <div class="calendario_caja">

        <div class="cabecera_titulo_pagina">
            <h2>{{ $fechaActual->translatedFormat('l d F Y') }}</h2>

            <div class="cabecera_titulo_botones">
                <a href="{{ route('admin.cita.vista.crear') }}" class="g_boton g_boton_primary">
                    Crear cita <i class="fa-solid fa-square-plus"></i></a>
            </div>
        </div>

        <div class="calendario_grid_dia">

            @foreach ($horas as $hora)

            @php
            $eventosHora = $items->filter(fn($ev) =>
            substr($ev['time'], 0, 2) === substr($hora, 0, 2)
            );
            @endphp

            <div class="calendario_hora_fila">

                <div class="hora">
                    {{ $hora }}
                </div>

                <div>

                    @forelse ($eventosHora as $ev)
                    <div class="calendario_cita_item">
                        <a href="{{ route('admin.cita.vista.editar', $ev['id'] ) }}" class="g_accion_editar">
                            <span><i class="fa-solid fa-eye"></i></span>
                        </a>

                        <div>
                            <strong>{{ $ev['time'] }} - {{ $ev['end_time'] }}</strong>
                        </div>

                        <div>
                            <span class="g_negrita">Motivo: {{ $ev['title'] }}</span>
                        </div>

                        <div>
                            <span>Cliente:</span>
                            {{ $ev['cliente'] }}
                        </div>

                        <div>
                            <span>Sede:</span>
                            {{ $ev['sede'] ?? '—' }}
                        </div>

                        <div>
                            <span class="g_negrita" style="color: {{ $ev['estado']->color }};">
                                {{ $ev['estado']->nombre }}
                            </span>
                        </div>
                    </div>
                    @empty
                    {{-- No hay eventos --}}
                    @endforelse

                </div>

            </div>

            @endforeach

        </div>
    </div>