<div>
    @if ($imagenId)
        <div class="g_modal">
            <div class="modal_contenedor">
                <div class="modal_cerrar">
                    <button wire:click="$dispatch('cerrarModalEditarImagen')"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <div class="modal_titulo g_titulo">
                    <h2>Editar imagen</h2>
                </div>

                <div class="modal_cuerpo">
                    <div class="formulario">
                        <!-- URL (lectura) -->
                        <div class="g_margin_bottom_20">
                            <label>Url</label>
                            <input type="text" readonly value="{{ $url }}" class="g_margin_bottom_20" disabled>
                            <div class="formulario_botones">
                                <button type="button" class="agregar" onclick="navigator.clipboard.writeText('{{ $url }}')">
                                    Copiar
                                </button>
                            </div>
                        </div>

                        <!-- TITULO -->
                        <div class="g_margin_bottom_20">
                            <label>Título <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span></label>
                            <input type="text" wire:model.defer="titulo">
                            <p class="leyenda">Se mostrará en el SEO.</p>
                            @error('titulo')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DESCRIPCION -->
                        <div class="g_margin_bottom_20">
                            <label>Descripción <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span></label>
                            <textarea wire:model.defer="descripcion"></textarea>
                            <p class="leyenda">Se mostrará en el SEO.</p>
                            @error('descripcion')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- PREVIEW ACTUAL -->
                        <div class="g_margin_bottom_20">
                            <label>Imagen actual</label>
                            <div class="dropzone_item">
                                <img src="{{ $url }}" class="dropzone_image">
                            </div>
                        </div>

                        <!-- CAMBIAR IMAGEN -->
                        <div class="cabecera_titulo_botones g_margin_bottom_20">
                            <a class="g_boton g_boton_primary">
                                <label for="imagen_edit" style="cursor: pointer;">Cambiar imagen <i class="fa-solid fa-square-plus"></i></label>
                            </a>
                            <input type="file" id="imagen_edit" wire:model="imagen_edit" accept="image/*" style="display: none;">
                        </div>

                        <div class="contenedor_dropzone">
                            @if ($imagen_edit)
                                <div class="dropzone_item">
                                    <img src="{{ $imagen_edit->temporaryUrl() }}" class="dropzone_image">
                                    <button type="button" wire:click="$set('imagen_edit', null)" class="remove_button">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            @else
                                <div class="g_vacio">
                                    <p>No hay imagen.</p>
                                    <i class="fa-regular fa-face-grin-wink"></i>
                                </div>
                            @endif
                        </div>

                        @error('imagen_edit')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="formulario_botones">
                        <button type="button" wire:click="editarFormulario" class="guardar">Actualizar</button>
                        <button type="button" wire:click="$dispatch('cerrarModalEditarImagen')" class="cancelar">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
