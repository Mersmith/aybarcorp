@php
$inicio = $fechaActual->copy()->startOfWeek();
@endphp

<div class="calendario_grid_mes">
    @for ($i = 0; $i < 7; $i++) @php $day=$inicio->copy()->addDays($i);
        $fecha = $day->toDateString();
        $items = collect($eventos)->where('date', $fecha);
        @endphp

        <div class="calendario_caja_dia">

            <div class="cabecera_titulo_pagina">
                <h2>{{ $day->translatedFormat('D d') }}</h2>

                <div class="cabecera_titulo_botones">
                    <button class="g_boton g_boton_success" wire:click="irAlDiaDeSemana('{{ $fecha }}')">
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