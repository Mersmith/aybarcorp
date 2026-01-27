<div>

    <div class="g_panel">

        <h2>Rendimiento de Gestores</h2>

        <div class="formulario">
            <div class="g_fila">

                <div class="g_columna_3">
                    <label>Estado</label>
                    <select wire:model.live="estadoId">
                        <option value="">Todos</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">
                                {{ $estado->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="g_columna_3">
                    <label>¿Tiene fecha de validación?</label>
                    <select wire:model.live="fechaValidacion">
                        <option value="">Todos</option>
                        <option value="si">Sí</option>
                        <option value="no">No</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="tabla_contenido">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Gestor</th>
                        <th>Cerradas por API</th>
                        <th>Cerradas Manual</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reporte as $fila)
                        <tr>
                            <td class="g_negrita">
                                {{ $fila->gestor->name ?? '—' }}
                            </td>
                            <td class="centrar">
                                {{ $fila->total_api }}
                            </td>
                            <td class="centrar">
                                {{ $fila->total_manual }}
                            </td>
                            <td class="centrar g_negrita">
                                {{ $fila->total_api + $fila->total_manual }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="centrar">
                                No hay datos para mostrar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>


    <div class="g_fila">
        <div class="g_columna_12">
            <div class="g_panel">
                <h2>Evidencia de pago recibidas(por Fecha)</h2>

                <div class="formulario">
                    <div class="g_fila">

                        <div class="g_columna_3">
                            <label>Seleccionar mes</label>
                            <input type="month" class="g_input" wire:model.live="mesSeleccionado" required>
                        </div>

                        <div class="g_columna_3">
                            <label>Unidad de negocio</label>
                            <select class="g_input" wire:model.live="unidadNegocioId">
                                <option value="">Todas</option>
                                @foreach ($unidadesNegocio as $unidad)
                                    <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="g_columna_3">
                            <label>Proyecto</label>
                            <select class="g_input" wire:model.live="proyectoId" @disabled(!$unidadNegocioId)>
                                <option value="">Todos</option>
                                @foreach ($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div wire:ignore>
                    <canvas id="graficoChartDiaMes" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="g_fila">
        <div class="g_columna_12">
            <div class="g_panel">
                <h2>Evidencia de pago por Razón Social</h2>
                <div class="formulario">
                    <div class="g_fila">

                        <div class="g_columna_3">
                            <label>Seleccionar mes</label>
                            <input type="month" class="g_input" wire:model.live="mesSeleccionado" required>
                        </div>

                        <div class="g_columna_3">
                            <label>Unidad de negocio</label>
                            <select class="g_input" wire:model.live="unidadNegocioId">
                                <option value="">Todas</option>
                                @foreach ($unidadesNegocio as $unidad)
                                    <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="g_columna_3">
                            <label>Proyecto</label>
                            <select class="g_input" wire:model.live="proyectoId" @disabled(!$unidadNegocioId)>
                                <option value="">Todos</option>
                                @foreach ($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div wire:ignore>
                    <canvas id="graficoChartPorUnidad" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let chartDiaMes = null;
    let chartPorUnidad = null;
    document.addEventListener('livewire:init', () => {

        const colores = ['#4F46E5', '#3B82F6', '#10B981', '#F59E0B', '#EF4444'];

        //GRAFICO 1
        const ctxChartDiaMes = document.getElementById('graficoChartDiaMes');
        chartDiaMes = new Chart(ctxChartDiaMes, {
            type: 'line',
            data: {
                labels: @json($solicitudesPorFecha['labels']),
                datasets: [{
                    label: 'Solicitudes',
                    data: @json($solicitudesPorFecha['data']),
                    borderColor: colores,
                    backgroundColor: colores,
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        Livewire.on('actualizarGraficoDiaMes', (payload) => {
            const data = payload[0];

            chartDiaMes.data.labels = data.labels;
            chartDiaMes.data.datasets[0].data = data.data;
            chartDiaMes.update();
        });

        // ===== GRAFICO 2: POR UNIDAD =====
        chartPorUnidad = new Chart(
            document.getElementById('graficoChartPorUnidad'), {
                type: 'bar',
                data: {
                    labels: @json($solicitudesPorUnidad['labels']),
                    datasets: [{
                        label: 'Solicitudes',
                        data: @json($solicitudesPorUnidad['data']),
                        backgroundColor: colores
                    }]
                },
                options: {
                    responsive: true
                }
            }
        );

        Livewire.on('actualizarGraficoPorUnidad', (payload) => {
            const data = payload[0];
            chartPorUnidad.data.labels = data.labels;
            chartPorUnidad.data.datasets[0].data = data.data;
            chartPorUnidad.update();
        });
    });
</script>
