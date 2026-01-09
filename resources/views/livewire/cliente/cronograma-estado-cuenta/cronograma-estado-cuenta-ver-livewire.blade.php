<div>
    <div class="cronograma_contenedor">
        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla_info">

                    <tr>
                        <td class="label">Proyecto</td>
                        <td class="valor grande" colspan="3">
                            {{ $estado_cuenta['Proyecto'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Etapa</td>
                        <td class="valor">
                            {{ $estado_cuenta['Etapa'] ?? '-' }}
                        </td>

                        <td class="label">Manzana - Lote</td>
                        <td class="valor">
                            {{ $estado_cuenta['Manzana'] ?? '-' }}
                            -
                            {{ $estado_cuenta['Lote'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Nombre Cliente</td>
                        <td class="valor" colspan="3">
                            {{ $estado_cuenta['Cliente'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">DNI</td>
                        <td class="valor"> {{ $estado_cuenta['DNI'] ?? '-' }} </td>

                        <td class="label">Fecha emisión</td>
                        <td class="valor"> {{ $estado_cuenta['FecEmision'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Precio Venta</td>
                        <td class="valor">S/ {{ $estado_cuenta['Venta'] ?? '-' }}</td>

                        <td class="label">Impor. Financiado</td>
                        <td class="valor">S/ {{ $estado_cuenta['ImporteFinanciado'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Inicial</td>
                        <td class="valor">S/ {{ $estado_cuenta['Inicial'] ?? '-' }}</td>

                        <td class="label">Impor. Amortizado</td>
                        <td class="valor">S/ {{ $estado_cuenta['importe_amortizado'] ?? '-' }}</td>
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
                            <th>Evidencia</th>
                            <th>Boleta</th>
                            <th>Letra digital</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($detalle ?? [] as $item)
                        <tr>
                            <td>{{ $item['NroCuota'] ?? '-' }}</td>
                            <td>{{ $item['FecVencimiento'] ?? '-' }}</td>
                            <td> S/ {{ $item['Cuota'] ?? 0 }}</td>
                            <td> S/ {{ $item['CuotaPagada'] ?? 0 }}</td>
                            <td>
                                @if (!$item['codigo_cronograma'] || $item['Comprobante'])
                                <span class="g_boton g_boton_empresa_primario"
                                    style="cursor: not-allowed; pointer-events: none;">
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
                            <td>
                                @if (!empty($item['Comprobante']))
                                @if (substr_count($item['Comprobante'], '-') === 2)
                                <a href="{{ route('slin.comprobante.ver', ['empresa' => $lote['id_empresa'], 'comprobante' => $item['Comprobante']]) }}"
                                    target="_blank" class="g_boton g_boton_empresa_primario">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>
                                @else
                                <x-tooltip text="Tu boleta está siendo confirmada!" />

                                <span class="g_boton g_boton_empresa_secundario"
                                    style="cursor: not-allowed; pointer-events: none;">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </span>
                                @endif
                                @endif
                            </td>
                            <td>
                                @if (!empty($item['NroCavali']))
                                <a href="{{ route('cavali.constancia.ver', $item['NroCavali']) }}" target="_blank"
                                    class="g_boton g_boton_empresa_primario" title="Ver letra digital firmada">
                                    <i class="fas fa-file-shield"></i>
                                </a>
                                @endif
                            </td>
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
                . $cuota['idCuota']))
            </div>
        </div>
    </div>
    @endif
</div>