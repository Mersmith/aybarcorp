@section('tituloPagina', 'Editar rol')

<div class="g_gap_pagina">

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar rol</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.rol.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.rol.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>

            <a href="{{ route('admin.rol.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <form wire:submit.prevent="store" class="formulario">
        <div class="g_fila">
            <div class="g_columna_12">
                <div class="g_panel">
                    <div class="g_margin_bottom_10">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" wire:model.live="name">
                        @error('name')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="g_fila g_margin_top_20">
            <div class="g_columna_12">

                <div class="g_panel">
                    <h4 class="g_panel_titulo">Permisos</h4>

                    @foreach ($permisos as $permiso)
                        <label>
                            <input type="checkbox" wire:model.live="permisosSeleccionados" value="{{ $permiso->name }}">
                            {{ $permiso->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="g_margin_top_20">
            <div class="formulario_botones">
                <button type="submit" class="guardar" wire:loading.attr="disabled" wire:target="store">
                    <span wire:loading.remove wire:target="store">Actualizar</span>
                    <span wire:loading wire:target="store">Actualizando...</span>
                </button>

                <a href="{{ route('admin.rol.vista.todo') }}" class="cancelar">Cancelar</a>
            </div>
        </div>
    </form>
</div>
