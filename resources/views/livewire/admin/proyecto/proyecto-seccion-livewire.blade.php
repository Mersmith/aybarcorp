@section('tituloPagina', 'Proyecto secciones')
@section('anchoPantalla', '100%')


<div x-data="dataProyectoSeccion()" class="g_gap_pagina">

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Proyecto secciones</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.proyecto.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.proyecto.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <form wire:submit.prevent="store" class="formulario g_gap_pagina">

        <div class="g_fila">
            <div class="g_columna_3 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Banner</h4>

                    <div class="g_margin_bottom_10">
                        <label for="">Imagen banner</label>
                        <input type="text" wire:model="banner_imagen" placeholder="">
                    </div>

                    <div class="">
                        <label for="">Youtube banner</label>
                        <textarea wire:model="banner_youtube" placeholder=""></textarea>
                    </div>
                </div>
            </div>

            <div class="g_columna_3 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Precio</h4>

                    <div class="g_margin_bottom_10">
                        <label for="">Texto</label>
                        <input type="text" wire:model="precio.texto" placeholder="">
                    </div>

                    <div class="">
                        <label for="">Monto</label>
                        <input type="text" wire:model="precio.monto" placeholder="">
                    </div>
                </div>
            </div>

            <div class="g_columna_3 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Aviso</h4>

                    <div class="g_margin_bottom_10">
                        <label for="">Texto 1</label>
                        <input type="text" wire:model="aviso.texto_1" placeholder="">
                    </div>

                    <div class="">
                        <label for="">Texto 2</label>
                        <input type="text" wire:model="aviso.texto_2" placeholder="">
                    </div>
                </div>
            </div>

            <div class="g_columna_3 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Mapa</h4>

                    <div class="g_margin_bottom_10">
                        <label for="">Imagen mapa</label>
                        <input type="text" wire:model="imagen_mapa" placeholder="">
                    </div>
                </div>
            </div>
        </div>

        <div class="g_fila">
            <div class="g_columna_6 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Iconos</h4>

                    <div class="formulario_botones g_margin_bottom_10">
                        <button type="button" wire:click="addIcono" class="agregar">
                            <i class="fa-solid fa-plus"></i> Agregar item
                        </button>
                    </div>

                    <table class="tabla_eliminar">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Texto</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($iconos as $index => $icono)
                                <tr wire:key="icono-{{ $icono['id'] }}">
                                    <td>
                                        <input type="text" wire:model="iconos.{{ $index }}.imagen"
                                            placeholder="">
                                    </td>
                                    <td>
                                        <input type="text" wire:model="iconos.{{ $index }}.texto"
                                            placeholder="">
                                    </td>
                                    <td>
                                        <button type="button" wire:click="removeIcono('{{ $icono['id'] }}')"
                                            class="boton_eliminar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="g_columna_6 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Galería</h4>

                    <div class="formulario_botones g_margin_bottom_10">
                        <button type="button" wire:click="addGaleria" class="agregar">
                            <i class="fa-solid fa-plus"></i> Agregar item
                        </button>
                    </div>

                    <table class="tabla_eliminar">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($galeria as $index => $item)
                                <tr wire:key="galeria-{{ $item['id'] }}">
                                    <td>
                                        <input type="text" wire:model="galeria.{{ $index }}.imagen"
                                            placeholder="">
                                    </td>

                                    <td>
                                        <button type="button" wire:click="removeGaleria('{{ $item['id'] }}')"
                                            class="boton_eliminar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="g_fila">
            <div class="g_columna_6 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Ofrecemos</h4>

                    <div class="formulario_botones g_margin_bottom_10">
                        <button type="button" wire:click="addOfrecemos" class="agregar">
                            <i class="fa-solid fa-plus"></i> Agregar item
                        </button>
                    </div>

                    <table class="tabla_eliminar">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Texto</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ofrecemos as $index => $ofrece)
                                <tr wire:key="ofrece-{{ $ofrece['id'] }}">
                                    <td>
                                        <input type="text" wire:model="ofrecemos.{{ $index }}.imagen"
                                            placeholder="">
                                    </td>
                                    <td>
                                        <input type="text" wire:model="ofrecemos.{{ $index }}.texto"
                                            placeholder="">
                                    </td>
                                    <td>
                                        <button type="button" wire:click="removeOfrecemos('{{ $ofrece['id'] }}')"
                                            class="boton_eliminar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="g_columna_6">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Videos YouTube</h4>

                    <div class="formulario_botones g_margin_bottom_10">
                        <button type="button" wire:click="addVideo" class="agregar">
                            <i class="fa-solid fa-plus"></i> Agregar video
                        </button>
                    </div>

                    <table class="tabla_eliminar">
                        <thead>
                            <tr>
                                <th>Iframe / URL YouTube</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($videos_youtube as $index => $video)
                                <tr wire:key="video-{{ $video['id'] }}">
                                    <td>
                                        <textarea wire:model="videos_youtube.{{ $index }}.iframe" placeholder="" rows="4"></textarea>
                                    </td>

                                    <td>
                                        <button type="button" wire:click="removeVideo('{{ $video['id'] }}')"
                                            class="boton_eliminar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="g_panel">
            <h4 class="g_panel_titulo">
                Turismo
                <button type="button" @click="toggleAll()">
                    <span x-show="globalVisible"><i class="fa-solid fa-angle-up"></i></span>
                    <span x-show="!globalVisible"><i class="fa-solid fa-angle-down"></i></span>
                </button>
            </h4>

            <div class="formulario_botones g_margin_bottom_10">
                <button type="button" wire:click="addTurismo" class="agregar">
                    <i class="fa-solid fa-plus"></i> Agregar item
                </button>
            </div>

            <div x-sort="handleBloque3Editar" class="g_gap_pagina">
                @foreach ($turismo as $index => $item)
                    <div class="g_panel tabla_caja">
                        <div class="cabecera">
                            <button type="button"
                                @click="itemsVisibility[{{ $index }}] = !itemsVisibility[{{ $index }}]">
                                <span x-show="itemsVisibility[{{ $index }}]"><i
                                        class="fa-solid fa-angle-up"></i></span>
                                <span x-show="!itemsVisibility[{{ $index }}]"><i
                                        class="fa-solid fa-angle-down"></i></span>
                            </button>
                        </div>

                        <div x-show="itemsVisibility[{{ $index }}]" x-transition>
                            <div class="g_fila">
                                <div class="g_margin_bottom_10 g_columna_6">
                                    <label for="">Imagen</label>
                                    <input type="text" wire:model="turismo.{{ $index }}.imagen"
                                        placeholder="">
                                </div>

                                <div class="g_margin_bottom_10 g_columna_6">
                                    <label for="">Título</label>
                                    <input type="text" wire:model="turismo.{{ $index }}.titulo"
                                        placeholder="">
                                </div>
                            </div>

                            <div class="g_fila">
                                <div class="g_margin_bottom_10 g_columna_12">
                                    <label for="">Descripción</label>
                                    <textarea wire:model="turismo.{{ $index }}.descripcion" placeholder="" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="g_margin_top_20">
            <div class="formulario_botones">
                <button type="submit" class="guardar" wire:loading.attr="disabled" wire:target="store">
                    <span wire:loading.remove wire:target="store">Actualizar</span>
                    <span wire:loading wire:target="store">Actualizando...</span>
                </button>

                <a href="{{ route('admin.proyecto.vista.todo') }}" class="cancelar">Cancelar</a>
            </div>
        </div>

    </form>

    <script>
        function dataProyectoSeccion() {
            return {
                globalVisible: true,
                itemsVisibility: Array(@js(count($turismo))).fill(true),

                init() {
                    Livewire.on('lista-updated', count => {
                        this.itemsVisibility = Array(count).fill(this.globalVisible);
                    });
                },

                toggleAll() {
                    this.globalVisible = !this.globalVisible;
                    this.itemsVisibility = Array(this.itemsVisibility.length).fill(this.globalVisible);
                },
            }
        }
    </script>

</div>
