@section('tituloPagina', 'Crear motivo cita')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Crear motivo cita</h2>
        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.motivo-cita.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.motivo-cita.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <div class="formulario">
        <div class="g_fila">
            <div class="g_columna_8 g_gap_pagina">
                <div class="g_panel">
                    <div class="g_margin_bottom_10">
                        <label for="nombre">Nombre <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="nombre" wire:model.live="nombre" required>
                        @error('nombre')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="g_margin_bottom_10">
                        <label for="icono">Icono</label>
                        <input type="text" id="icono" wire:model.live="icono">
                        <p class="leyenda">Ejemplo: fa-solid fa-clock</p>
                        @error('icono')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="color">Color</label>
                        <input type="color" id="color" wire:model.live="color">
                        @error('color')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
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
                <button wire:click="crearTipoSolicitud" class="guardar" wire:loading.attr="disabled">Guardar</button>
                <a href="{{ route('admin.motivo-cita.vista.todo') }}" class="cancelar">Cancelar</a>
            </div>
        </div>
    </div>
</div>
