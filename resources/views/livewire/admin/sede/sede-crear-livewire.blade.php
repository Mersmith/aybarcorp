@section('tituloPagina', 'Crear sede')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Crear sede</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.sede.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{ route('admin.sede.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <form wire:submit.prevent="store" class="formulario">
        <div class="g_fila">
            <div class="g_columna_8 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">General</h4>

                    <div class="g_margin_bottom_10">
                        <label for="nombre">Nombre <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="nombre" wire:model.live="nombre">
                        @error('nombre')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="direccion">Dirección <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="direccion" wire:model.live="direccion">
                        @error('direccion')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="g_columna_4 g_gap_pagina g_columna_invertir">
            <div class="g_panel">
                <h4 class="g_panel_titulo">Activo</h4>
                <select id="activo" wire:model.live="activo">
                    <option value="0">DESACTIVADO</option>
                    <option value="1">ACTIVO</option>
                </select>
            </div>
        </div>
</div>

<div class="g_margin_top_20">
    <div class="formulario_botones">
        <button type="submit" class="guardar" wire:loading.attr="disabled" wire:target="store">
            <span wire:loading.remove wire:target="store">Crear</span>
            <span wire:loading wire:target="store">Guardando...</span>
        </button>

        <a href="{{ route('admin.sede.vista.todo') }}" class="cancelar">Cancelar</a>
    </div>
</div>

</form>
</div>
