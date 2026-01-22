@section('tituloPagina', 'Evidencias pago')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Validación de evidencia de pago portal cliente</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.evidencia-pago.vista.todo') }}" class="g_boton g_boton_light">
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
                    <label>Cliente/DNI/Nombres</label>
                    <input type="text" wire:model.live.debounce.1300ms="buscar" id="buscar" name="buscar">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Empresa </label>
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

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Gestor</label>
                    <select wire:model.live="admin">
                        <option value="">Todos</option>
                        <option value="sin_asignar">FALTA ASIGNAR</option>

                        @foreach ($usuarios_admin as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
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
            </div>

            <div class="g_fila">
                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Fecha inicio</label>
                    <input type="date" wire:model.live="fecha_inicio">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Fecha fin</label>
                    <input type="date" wire:model.live="fecha_fin">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Tipo de cierre</label>
                    <select wire:model.live="tipo_cierre">
                        <option value="">TODOS</option>
                        <option value="api">CERRADO CON API</option>
                        <option value="manual">CERRADO MANUAL</option>
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>¿Tiene fecha validación?</label>
                    <select wire:model.live="tiene_validacion">
                        <option value="">TODOS</option>
                        <option value="si">SÍ</option>
                        <option value="no">NO</option>
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>¿SLIN Asbanc?</label>
                    <select wire:model.live="es_asbanc">
                        <option value="">TODOS</option>
                        <option value="si">SÍ</option>
                        <option value="no">NO</option>
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
                            <th>Gestor</th>
                            <th>Razón S.</th>
                            <th>Proyecto</th>
                            <th>Etapa</th>
                            <th>Mz.</th>
                            <th>Lt.</th>
                            <th>N° Cuota</th>
                            <th>Cliente</th>
                            <th>Dni</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>

                    @if ($evidencias->count())
                        <tbody>
                            @foreach ($evidencias as $index => $item)
                                <tr>
                                    <td>{{ $evidencias->firstItem() + $index }}</td>
                                    <td class="g_negrita g_resumir">
                                        {{ $item->gestor?->name ?? 'Falta asignar' }}
                                    </td>
                                    <td class="g_resumir">{{ $item->unidadNegocio->nombre }}</td>
                                    <td class="g_resumir">{{ $item->proyecto->nombre }}</td>
                                    <td class="g_resumir">{{ $item->etapa }}</td>
                                    <td class="g_resumir">{{ $item->manzana }}</td>
                                    <td class="g_resumir">{{ $item->lote }}</td>
                                    <td class="g_resumir">{{ $item->numero_cuota }}</td>
                                    <td class="g_negrita g_resumir">{{ $item->userCliente->name }}</td>
                                    <td> {{ $item->userCliente?->cliente?->dni ?? '—' }}</td>
                                    <td>
                                        <span style="color: {{ $item->estado->color }};">
                                            <i class="{{ $item->estado->icono }}"></i> {{ $item->estado->nombre }}
                                        </span>
                                    </td>
                                    <td class="centrar_iconos">
                                        <a href="{{ route('admin.evidencia-pago.vista.editar', $item->id) }}"
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
        @else
            <div class="g_paginacion">
                Mostrando {{ $evidencias->firstItem() ?? 0 }} – {{ $evidencias->lastItem() ?? 0 }}
                de {{ $evidencias->total() }} registros
            </div>
        @endif
    </div>
</div>
