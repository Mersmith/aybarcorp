<div>
    <div class="cronograma_contenedor">
        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla_info">

                    <tr>
                        <td class="label">Proyecto</td>
                        <td class="valor grande" colspan="3">{{ $lote['descripcion'] }}</td>
                    </tr>

                    <tr>
                        <td class="label">Etapa</td>
                        <td class="valor">{{ $lote['id_etapa'] }}</td>

                        <td class="label">Manzana - Lote</td>
                        <td class="valor">{{ $lote['id_manzana'] }} - {{ $lote['id_lote'] }}</td>
                    </tr>

                    <tr>
                        <td class="label">Nombre Cliente</td>
                        <td class="valor" colspan="3">{{ $lote['apellidos_nombres'] }}</td>
                    </tr>

                    <tr>
                        <td class="label">DNI</td>
                        <td class="valor">{{ $lote['nit'] }}</td>

                        <td class="label">Código pago</td>
                        <td class="valor">{{ $lote['id_recaudo'] }}</td>
                    </tr>

                    <tr>
                        <td class="label">N° Cuotas</td>
                        <td class="valor">{{ $lote['nro_cuotas'] }}</td>

                        <td class="label">Cuotas pagadas</td>
                        <td class="valor">{{ $total_pagados }}</td>
                    </tr>

                </table>
            </div>
        </div>

        <!-- TABLA DETALLE DsEL CRONOGRAMA -->
        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla_detalle">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Fecha Venc.</th>
                            <th>Cuota</th>
                            <th>Mto. Amortizado</th>
                            <th>Saldo</th>
                            <th>Estado</th>
                            <th>Evidencia</th>
                            {{--<th>Boleta</th>
                            <th>Letra</th>--}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cronograma as $item)
                        <tr>
                            <td>{{ $item['cuota'] }}</td>
                            <td>{{ $item['fec_vencimiento'] }}</td>
                            <td>S/ {{ number_format($item['monto'], 2) }}</td>
                            <td>S/ {{ number_format($item['amortizacion'], 2) }}</td>
                            <td>S/ {{ number_format($item['saldo'], 2) }}</td>
                            <td>{{ $item['estado'] }}
                                {{--
                                <x-tooltip text="Este estado indica en qué etapa se encuentra el proceso." /> --}}
                            </td>
                            <td>
                                @if ($item['estado'] == 'PAGADO')
                                <span class="g_boton g_boton_empresa_primario">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Comprobado
                                </span>
                                @else
                                @if ($item['comprobantes_count'] == 2)
                                <span class="g_boton g_boton_darkt">
                                    <i class="fa-solid fa-image"></i>
                                    En validación({{ $item['comprobantes_count'] }})
                                </span>
                                @elseif($item['comprobantes_count'] == 1)
                                <button wire:click="seleccionarCuota({{ json_encode($item) }})"
                                    class="g_boton g_boton_darkt">
                                    <i class="fas fa-upload"></i> En validación
                                    ({{ $item['comprobantes_count'] }})
                                </button>
                                @else
                                <button wire:click="seleccionarCuota({{ json_encode($item) }})"
                                    class="g_boton g_boton_empresa_secundario">
                                    <i class="fas fa-upload"></i> Subir evidencia
                                </button>
                                @endif
                                @endif
                            </td>
                            {{--<td></td>
                            <td></td>--}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($cuota)
    <div class="g_modal">
        <div class="modal_contenedor">
            <div class="modal_cerrar">
                <button wire:click="cerrarModalEvidenciaPago"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="modal_titulo g_panel_titulo">
                <h2>Subir evidencia de pago</h2>
            </div>

            <div class="modal_cuerpo">
                @livewire('cliente.open-ai.procesar-imagen-livewire', ['cuota' => $cuota, 'lote' => $lote], key('cuota_'
                . $cuota['codigo']))
            </div>
        </div>
    </div>
    @endif
</div>