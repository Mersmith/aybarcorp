@section('tituloPagina', 'Evidencias pago antiguo')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Importar evidencia pago stock</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.evidencia-pago-antiguo.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>
        </div>
    </div>

    <div class="g_panel">
        @if ($errors->has('archivo'))
            <div class="g_alerta_error">
                {{ $errors->first('archivo') }}
            </div>
        @endif

        <form wire:submit.prevent="importar" class="formulario">
            <div class="g_margin_bottom_10">
                <label for="archivo">Archivo excel <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span></label>
                <input type="file" wire:model="archivo">
                @error('archivo')
                    <p class="mensaje_error">{{ $message }}</p>
                @enderror
            </div>

            <div class="g_margin_top_20">
                <div class="formulario_botones">
                    <button type="submit" class="guardar" wire:loading.attr="disabled">Importar Excel</button>
                </div>
            </div>
        </form>
    </div>
</div>
