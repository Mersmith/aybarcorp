@section('tituloPagina', 'Imágenes')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <!--CABECERA TITULO PAGINA-->
    <div class="g_panel cabecera_titulo_pagina">
        <!--TITULO-->
        <h2>Imagenes</h2>

        <!--BOTONES-->
        <div class="cabecera_titulo_botones">
            <a class="g_boton g_boton_primary">
                <label for="imagenes_inicial" style="cursor: pointer;">Subir <i
                        class="fa-solid fa-square-plus"></i></label>
            </a>
        </div>
    </div>

    <livewire:marketing.imagen.imagen-formulario-livewire />

    <livewire:marketing.imagen.imagen-lista-livewire />

    @if ($imagenSeleccionadaId)
        <livewire:marketing.imagen.imagen-editar-livewire :imagenId="$imagenSeleccionadaId" wire:key="editar-{{ $imagenSeleccionadaId }}" />
    @endif
</div>
