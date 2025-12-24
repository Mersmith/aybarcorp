<div>
    @if ($archivoId)
    <div class="g_modal">
        <div class="modal_contenedor">
            <div class="modal_cerrar">
                <button wire:click="$dispatch('cerrarModalEditarArchivo')"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="modal_titulo g_titulo">
                <h2>Editar archivo</h2>
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
                        <label>Archivo actual</label>
                        <div class="dropzone_item">
                            @php
                            $extension = strtolower(pathinfo($archivo_original->path, PATHINFO_EXTENSION));

                            $iconos = [
                            'pdf' => 'fa-file-pdf text-red-600',
                            'docx' => 'fa-file-word text-blue-600',
                            'xlsx' => 'fa-file-excel text-green-600',
                            'pptx' => 'fa-file-powerpoint text-orange-500',
                            ];
                            @endphp

                            <div class="icono_archivo">
                                <i class="fa-solid {{ $iconos[$extension] ?? 'fa-file text-gray-500' }}"></i>
                                <small>{{ strtoupper($extension) }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- CAMBIAR IMAGEN -->
                    <div class="cabecera_titulo_botones g_margin_bottom_20">
                        <a class="g_boton g_boton_primary">
                            <label for="archivo_edit" style="cursor: pointer;">Cambiar archivo <i
                                    class="fa-solid fa-square-plus"></i></label>
                        </a>
                        <input type="file" id="archivo_edit" wire:model="archivo_edit" accept=".docx,.xlsx,.pptx,.pdf*"
                            style="display: none;">
                    </div>

                    <div class="contenedor_dropzone">
                        @if ($archivo_edit)
                        <div class="dropzone_item">
                            @php
                            // Detectar tipo de archivo
                            $extension = method_exists($archivo_edit, 'getClientOriginalExtension')
                            ? strtolower($archivo_edit->getClientOriginalExtension())
                            : null;

                            $iconos = [
                            'pdf' => 'fa-file-pdf text-red-600',
                            'docx' => 'fa-file-word text-blue-600',
                            'xlsx' => 'fa-file-excel text-green-600',
                            'pptx' => 'fa-file-powerpoint text-orange-500',
                            ];
                            @endphp

                            <div class="dropzone_icono">
                                <i class="fa-solid {{ $iconos[$extension] ?? 'fa-file text-gray-500' }}"></i>
                                <small>{{ strtoupper($extension) }}</small>
                            </div>

                            <button type="button" wire:click="$set('archivo_edit', null)" class="remove_button">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        @else
                        <div class="g_vacio">
                            <p>No hay archivo.</p>
                            <i class="fa-regular fa-face-grin-wink"></i>
                        </div>
                        @endif
                    </div>

                    @error('archivo_edit')
                    <p class="mensaje_error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="formulario_botones">
                    <button type="button" wire:click="editarFormulario" class="guardar">Actualizar</button>
                    <button type="button" wire:click="$dispatch('cerrarModalEditarArchivo')"
                        class="cancelar">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
