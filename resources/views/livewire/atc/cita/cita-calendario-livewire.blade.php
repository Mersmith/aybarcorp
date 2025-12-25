@section('tituloPagina', 'Citas')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Calendario</h2>

        <div class="cabecera_titulo_botones">
            <button wire:click="cambiarVista('anio')"
                class="g_boton {{ $vista === 'anio' ? 'g_boton_primary' : 'g_boton_light' }}">
                Año
            </button>
            <button wire:click="cambiarVista('mes')"
                class="g_boton {{ $vista === 'mes' ? 'g_boton_primary' : 'g_boton_light' }}">
                Mes
            </button>
            <button wire:click="cambiarVista('semana')"
                class="g_boton {{ $vista === 'semana' ? 'g_boton_primary' : 'g_boton_light' }}">
                Semana
            </button>
            <button wire:click="cambiarVista('dia')"
                class="g_boton {{ $vista === 'dia' ? 'g_boton_primary' : 'g_boton_light' }}">
                Día
            </button>

            <button wire:click="irHoy()"
                class="g_boton {{ $vista === 'dia' && $fechaActual->isToday() ? 'g_boton_success' : 'g_boton_light' }}">
                Hoy
            </button>
        </div>
    </div>

    <div class="g_panel">
        <div class="calendario_cabecera">
            <button wire:click="navegar(-1)">◀</button>

            <h2>
                @switch($vista)
                @case('mes') {{ $fechaActual->translatedFormat('F Y') }} @break
                @case('semana') Semana {{ $fechaActual->weekOfYear }} @break
                @case('dia') {{ $fechaActual->translatedFormat('d F Y') }} @break
                @case('anio') {{ $fechaActual->year }} @break
                @endswitch
            </h2>

            <button wire:click="navegar(1)">▶</button>
        </div>

        @include("livewire.atc.cita.vistas.{$vista}")
    </div>

</div>