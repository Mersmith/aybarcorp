@section('tituloPagina', 'Envíos CAVALI')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Envíos CAVALI</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.envios-cavali.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <button wire:click="resetFiltros" class="g_boton g_boton_danger">
                Refresh Filtros <i class="fa-solid fa-rotate-left"></i>
            </button>
        </div>
    </div>

    <div class="g_panel">

        <div class="formulario">
            <div class="g_fila">
                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Buscar (Fecha/Empresa)</label>
                    <input type="text" wire:model.live.debounce.1300ms="buscar" id="buscar" name="buscar"
                        placeholder="2026-01-29 o VIVANORTE">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Estado</label>
                    <select wire:model.live="estado">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="enviado">Enviado</option>
                        <option value="observado">Observado</option>
                        <option value="aceptado">Aceptado</option>
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Unidad de Negocio</label>
                    <select wire:model.live="unidad_negocio_id">
                        <option value="">Todas</option>
                        @foreach($unidadesNegocio as $unidad)
                            <option value="{{ $unidad->id }}">{{ $unidad->razon_social }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div>
            <label>Items</label>
            <select wire:model.live="perPage">
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <div class="tabla_contenido g_margin_bottom_20">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Fecha Corte</th>
                            <th>Unidad de Negocio</th>
                            <th>Estado</th>
                            <th>Solicitudes</th>
                            <th>Fecha Envío</th>
                            <th>Archivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    @if ($items->count())
                        <tbody>
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td>{{ $items->firstItem() + $index }}</td>
                                    <td class="g_negrita">{{ $item->fecha_corte->format('d/m/Y') }}</td>
                                    <td class="g_resumir">{{ $item->unidadNegocio->razon_social }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match ($item->estado) {
                                                'pendiente' => 'g_badge_warning',
                                                'enviado' => 'g_badge_info',
                                                'observado' => 'g_badge_danger',
                                                'aceptado' => 'g_badge_success',
                                                default => 'g_badge_secondary'
                                            };
                                        @endphp
                                        <span class="g_badge {{ $badgeClass }}">{{ ucfirst($item->estado) }}</span>
                                    </td>
                                    <td class="g_negrita">{{ $item->solicitudes_count }}</td>
                                    <td>{{ $item->enviado_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                    <td class="g_resumir">{{ $item->archivo_nombre ?? '—' }}</td>
                                    <td>
                                        <a href="{{ route('admin.cavali.envios.show', $item->id) }}"
                                            class="g_boton g_boton_primary g_boton_sm">
                                            <i class="fa-solid fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>


        @if ($items->hasPages())
            <div class="g_paginacion">
                {{ $items->links('vendor.pagination.default-livewire') }}
            </div>
        @endif

        @if ($items->count() == 0)
            <div class="g_vacio">
                <p>No hay envíos CAVALI disponibles.</p>
                <i class="fa-regular fa-face-grin-wink"></i>
            </div>
        @else
            <div class="g_paginacion">
                Mostrando {{ $items->firstItem() ?? 0 }} – {{ $items->lastItem() ?? 0 }}
                de {{ $items->total() }} registros
            </div>
        @endif
    </div>
</div>