@php
$inicioMes = $fechaActual->copy()->startOfMonth();
$primerDiaSemana = $inicioMes->dayOfWeekIso;
$diasEnMes = $inicioMes->daysInMonth;
@endphp

<div class="calendario_grid_mes">
    @for ($i = 1; $i < $primerDiaSemana; $i++) <div class="calendario_caja_dia vacio">
</div>
@endfor

@for ($dia = 1; $dia <= $diasEnMes; $dia++) @php $fecha=$fechaActual->copy()->day($dia)->toDateString();
    $items = collect($eventos)->where('date', $fecha);
    @endphp

    <div class="calendario_caja_dia">

        <div class="cabecera_titulo_pagina">
            <h2>{{ $dia }}</h2>

            <div class="cabecera_titulo_botones">
                <button class="g_boton g_boton_success" wire:click.stop="irAlDiaDeMes({{ $dia }})">
                    Abrir
                </button>
            </div>
        </div>

        @foreach ($items as $ev)
        <div class="calendario_lista">
            {{ $ev['title'] }}
        </div>
        @endforeach

    </div>
    @endfor
    </div>