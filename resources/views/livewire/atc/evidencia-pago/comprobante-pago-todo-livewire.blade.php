@section('tituloPagina', 'Evidencias pago')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Evidencias pago</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.comprobante-pago.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <button wire:click="resetFiltros" class="g_boton g_boton_danger">
                Limpiar Filtros <i class="fa-solid fa-rotate-left"></i>
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

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Estado </label>
                    <select wire:model.live="estado_id">
                        <option value="">TODOS</option>
                        @foreach ($estados as $estadoItem)
                        <option value="{{ $estadoItem->id }}">{{ $estadoItem->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Razón Social </label>
                    <select wire:model.live="unidad_negocio_id">
                        <option value="">TODOS</option>
                        @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Proyecto </label>
                    <select wire:model.live="proyecto_id">
                        <option value="">TODOS</option>
                        @foreach ($proyectos as $proyecto)
                        <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="tabla_contenido g_margin_bottom_20">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Razón S.</th>
                            <th>Proyecto</th>
                            <th>Mz.</th>
                            <th>Lt.</th>
                            <th>N° Cuota</th>
                            <th>Imagen</th>
                            <th>Cliente</th>
                            <th>Dni</th>
                            <th>N° Operación</th>
                            <th>Banco</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>

                    @if ($evidencias->count())
                    <tbody>
                        @foreach ($evidencias as $index => $item)
                        <tr>
                            <td> {{ $index + 1 }} </td>
                            <td class="g_resumir">{{ $item->unidadNegocio->nombre }}</td>
                            <td class="g_resumir">{{ $item->proyecto->nombre }}</td>
                            <td class="g_resumir">{{ $item->manzana }}</td>
                            <td class="g_resumir">{{ $item->lote }}</td>
                            <td class="g_resumir">{{ $item->numero_cuota }}</td>
                            <td>
                                @if ($item->url)
                                <a href="{{ $item->url }}" target="_blank" class="g_accion_editar"
                                    title="Ver evidencia">
                                    <i class="fa-regular fa-file-image fa-xl"></i>
                                </a>
                                @else
                                <span class="g_texto_secundario">Sin imagen</span>
                                @endif
                            </td>
                            <td class="g_negrita g_resumir">{{ $item->cliente->user->name }}</td>
                            <td>{{ $item->cliente->dni }}</td>
                            <td>{{ $item->numero_operacion }}</td>
                            <td>{{ $item->banco }}</td>
                            <td>{{ $item->monto}}</td>
                            <td>{{ $item->fecha}}</td>
                            <td>
                                <span style="color: {{ $item->estado->color }};">
                                    <i class="{{ $item->estado->icono }}"></i> {{$item->estado->nombre }}
                                </span>
                            </td>
                            <td class="centrar_iconos">
                                <a href="{{ route('admin.comprobante-pago.vista.editar', $item->id) }}"
                                    class="g_accion_editar">
                                    <span><i class="fa-solid fa-pencil"></i></span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>
            </div>
        </div>


        @if ($evidencias->hasPages())
        <div class="g_paginacion">
            {{ $evidencias->links('vendor.pagination.default-livewire') }}
        </div>
        @endif

        @if ($evidencias->count() == 0)
        <div class="g_vacio">
            <p>No hay evidencias disponibles.</p>
            <i class="fa-regular fa-face-grin-wink"></i>
        </div>
        @endif
    </div>
</div>