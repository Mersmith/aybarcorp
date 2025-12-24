@section('tituloPagina', 'Archivos')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <!--CABECERA TITULO PAGINA-->
    <div class="g_panel cabecera_titulo_pagina">
        <!--TITULO-->
        <h2>Archivos</h2>

        <!--BOTONES-->
        <div class="cabecera_titulo_botones">
            <a class="g_boton g_boton_primary">
                <label for="archivos_inicial" style="cursor: pointer;">Subir <i
                        class="fa-solid fa-square-plus"></i></label>
            </a>
        </div>
    </div>

    <livewire:marketing.archivo.archivo-formulario-livewire />

    <livewire:marketing.archivo.archivo-lista-livewire />

    @if ($archivoSeleccionadaId)
    <livewire:marketing.archivo.archivo-editar-livewire :archivoId="$archivoSeleccionadaId"
        wire:key="editar-{{ $archivoSeleccionadaId }}" />
    @endif
</div>
