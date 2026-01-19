@section('tituloPagina', 'Letras digitales')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Solicitudes de letras digitales portal cliente</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.solicitar-letra-digital.vista.todo') }}" class="g_boton g_boton_light">
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
                    <label>DNI/Nombres</label>
                    <input type="text" wire:model.live.debounce.1300ms="buscar" id="buscar" name="buscar">
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
                            <th>Razón S.</th>
                            <th>Proyecto</th>
                            <th>Etapa</th>
                            <th>Mz.</th>
                            <th>Lt.</th>
                            <th>N° Cuota</th>
                            <th>Cliente</th>
                            <th>Dni</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>

                    @if ($items->count())
                    <tbody>
                        @foreach ($items as $index => $item)
                        <tr>
                            <td>{{ $items->firstItem() + $index }}</td>
                            <td class="g_resumir">{{ $item->unidadNegocio->nombre }}</td>
                            <td class="g_resumir">{{ $item->proyecto->nombre }}</td>
                            <td class="g_resumir">{{ $item->etapa }}</td>
                            <td class="g_resumir">{{ $item->manzana }}</td>
                            <td class="g_resumir">{{ $item->lote }}</td>
                            <td class="g_resumir">{{ $item->numero_cuota }}</td>
                            <td class="g_negrita g_resumir">{{ $item->userCliente->name }}</td>
                            <td> {{ $item->userCliente?->cliente?->dni ?? '—' }}</td>
                            <td>{{ $item->created_at }}</td>
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
            <p>No hay items disponibles.</p>
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