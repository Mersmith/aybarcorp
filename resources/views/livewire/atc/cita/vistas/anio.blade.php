<div class="calendario_grid_anio">

    @for ($m = 1; $m <= 12; $m++) @php $fechaMes=\Carbon\Carbon::create($fechaActual->year, $m, 1);

        // Total de eventos en ese mes
        $totalMes = collect($eventos)->filter(function ($e) use ($m) {
        return \Carbon\Carbon::parse($e['date'])->month == $m;
        })->count();
        @endphp

        <div class="calendario_caja">
            <div class="cabecera_titulo_pagina">
                <h2>{{ $fechaMes->translatedFormat('F') }}</h2>

                <div class="cabecera_titulo_botones">
                    <button class="g_boton g_boton_success" wire:click="irAlMes({{ $m }})">
                        Abrir
                    </button>
                </div>
            </div>

            <div>
                <span class="g_badge g_negrita">{{ $totalMes }} citas</span>
            </div>
        </div>
        @endfor
</div>