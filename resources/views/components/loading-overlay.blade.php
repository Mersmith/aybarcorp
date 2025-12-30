@props([
'message' => 'Cargando información…'
])

<div wire:loading class="contenedor_spiner_load">
    <div class="spinner_box">
        <div class="spinner_icon"></div>
        <span class="spinner_text">{{ $message }}</span>
    </div>
</div>