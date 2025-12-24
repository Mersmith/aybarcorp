<form wire:submit.prevent="guardar" class="formulario">
    <div class="g_panel">
        <div class="g_margin_bottom_20">
            <input type="file" id="imagenes_inicial" wire:model="imagenes_inicial" multiple accept="image/*"
                style="display: none;">

            <div class="contenedor_dropzone">
                @if ($imagenes_final && count($imagenes_final))
                    @foreach ($imagenes_final as $index => $photo)
                        <div class="dropzone_item">
                            @if (method_exists($photo, 'temporaryUrl'))
                                <img src="{{ $photo->temporaryUrl() }}" class="dropzone_image">
                            @endif

                            <button type="button" class="remove_button"
                                wire:click="eliminarImagenTemporal({{ $index }})">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="g_vacio">
                        <p>No hay imagen.</p>
                        <i class="fa-regular fa-face-grin-wink"></i>
                    </div>
                @endif
            </div>
        </div>

        @error('imagenes_final')
            <p class="mensaje_error">{{ $message }}</p>
        @enderror

        @if ($imagenes_final && count($imagenes_final))
            <div class="formulario_botones">
                <button type="submit" class="guardar">Guardar</button>
            </div>
        @endif
    </div>
</form>