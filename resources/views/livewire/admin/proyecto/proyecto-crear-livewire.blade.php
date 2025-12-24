@section('tituloPagina', 'Crear proyecto')
@section('anchoPantalla', '100%')

<div x-data="dataBlogCrear" class="g_gap_pagina">
    <!-- CABECERA -->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Crear proyecto</h2>
        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.proyecto.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.proyecto.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <!-- FORMULARIO -->
    <div class="formulario">
        <div class="g_fila">
            <div class="g_columna_8 g_gap_pagina">
                <div class="g_panel">
                    <!-- Titulo -->
                    <div class="g_margin_bottom_10">
                        <label for="nombre">Nombre <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="nombre" wire:model.live="nombre" required>
                        @error('nombre')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!--SLUG-->
                    <div class="g_margin_bottom_10">
                        <label for="slug">Slug <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="slug" name="slug" wire:model.live="slug" required disabled>
                        <p class="leyenda">Se genera automático</p>
                        @error('slug')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Imagen -->
                    <div class="g_margin_bottom_10">
                        <label for="imagen">Imagen <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="imagen" wire:model.live="imagen" required>
                        @error('imagen')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="g_panel">
                    <!-- contenido -->
                    <div wire:ignore style="g_ckeditor">
                        <label for="contenido">Contenido</label>
                        <textarea id="contenido" class="w-full form-control" rows="6" wire:ignore x-data x-init="ClassicEditor.create($refs.miEditorProyecto, {
                                toolbar: [
                                    'undo', 'redo', '|',
                                    'heading', '|',
                                    'bold', 'italic', '|',
                                    'link', 'uploadImage', 'insertTable', 'blockQuote',
                                    'mediaEmbed', '|',
                                    'bulletedList', 'numberedList', '|',
                                    'outdent', 'indent'
                                ],
                                ckfinder: {
                                    uploadUrl: '{{ route('admin.imagen.upload-local') }}?_token={{ csrf_token() }}'
                                },
                                link: {
                                    addTargetToExternalLinks: true,
                                    defaultProtocol: 'https://'
                                }
                            })
                            .then(editor => {
                                editor.model.document.on('change:data', () => {
                                    @this.set('contenido', editor.getData())
                                });
                            })
                            .catch(error => {
                                console.error(error);
                            });"
                            x-ref="miEditorProyecto">{!! $contenido !!}</textarea>

                        @error('contenido')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- LISTA -->
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Documentos</h4>

                    <div class="formulario_botones g_margin_bottom_10">
                        <button type="button" wire:click="agregarItem" class="agregar">
                            <i class="fa-solid fa-plus"></i> Agregar item
                        </button>
                    </div>

                    <table class="tabla_eliminar">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Texto</th>
                                <th>Link</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody x-sort="handleBlogCrear">
                            @foreach ($lista as $index => $item)
                                <tr class="sorteable_item" x-sort:item="{{ $item['id'] }}"
                                    wire:key="item-{{ $index }}">
                                    <td>
                                        <div x-sort:handle class="handle cursor-move" title="Arrastra aquí"
                                            style="touch-action: none; cursor: grab;">
                                            <i class="fa-solid fa-up-down-left-right"></i>
                                            {{ $item['id'] }}
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" wire:model="lista.{{ $index }}.texto"
                                            wire:key="texto-{{ $index }}" @pointerdown.stop @mousedown.stop
                                            @touchstart.stop draggable="false">
                                        <input type="color" wire:model="lista.{{ $index }}.texto_color"
                                            wire:key="texto_color-{{ $index }}">
                                        @error("lista.$index.texto")
                                            <p class="mensaje_error">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" wire:model="lista.{{ $index }}.link"
                                            wire:key="link-{{ $index }}" @pointerdown.stop @mousedown.stop
                                            @touchstart.stop draggable="false">
                                        <input type="color" wire:model="lista.{{ $index }}.boton_color"
                                            wire:key="boton_color-{{ $index }}">
                                    </td>
                                    <td>
                                        <button type="button" wire:click="eliminarItem({{ $index }})"
                                            class="boton_eliminar" wire:key="boton-eliminar-{{ $index }}"
                                            @pointerdown.stop @mousedown.stop @touchstart.stop draggable="false">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="g_columna_4 g_gap_pagina g_columna_invertir">
                <!-- Activo -->
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Activo</h4>
                    <select id="activo" wire:model.live="activo">
                        <option value="0">DESACTIVADO</option>
                        <option value="1">ACTIVO</option>
                    </select>
                </div>

                <div class="g_panel">
                    <!-- Titulo -->
                    <div class="g_margin_bottom_10">
                        <label for="meta_title">Meta titulo <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="meta_title" wire:model.live="meta_title" required>
                        @error('meta_title')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!--DESCRIPCION-->
                    <div class="">
                        <label for="meta_description">Meta descripción <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <textarea id="meta_description" wire:model.live="meta_description" rows="3"></textarea>
                        @error('meta_description')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Imagen -->
                    <div class="g_margin_bottom_10">
                        <label for="meta_image">Meta imagen <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="meta_image" wire:model.live="meta_image" required>
                        @error('meta_image')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTONES -->
        <div class="formulario_botones">
            <button wire:click="crearPost" class="guardar" wire:loading.attr="disabled">Guardar</button>
            <a href="{{ route('admin.proyecto.vista.todo') }}" class="cancelar">Cancelar</a>
        </div>
    </div>

    <script>
        function dataBlogCrear() {
            return {
                handleBlogCrear(item, position) {
                    Livewire.dispatch('handleBlogCrearOn', {
                        item,
                        position
                    });
                },
            }
        }
    </script>

</div>
