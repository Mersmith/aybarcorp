<div class="g_gap_pagina">

    <div class="g_fila g_panel">
        <div style="flex: 1 1 300px;">
            <h2 class="g_panel_titulo">Resumen</h2>

            <div class="g_fila" style="display: flex; flex-wrap: wrap; gap: 15px;">

                <div class="g_panel" style="flex: 1 1 150px; padding:15px; text-align:center;">
                    <h3 class="g_texto_gris">Total evidencias</h3>
                    <p class="g_numero_grande">{{ \App\Models\EvidenciaPago::count() }}</p>
                </div>

                <div class="g_panel" style="flex: 1 1 150px; padding:15px; text-align:center;">
                    <h3>Pendientes</h3>
                    <p class="g_numero_grande">
                        {{ \App\Models\EvidenciaPago::whereNull('fecha_validacion')->count() }}
                    </p>
                </div>

                <div class="g_panel" style="flex: 1 1 150px; padding:15px; text-align:center;">
                    <h3>Validadas hoy</h3>
                    <p class="g_numero_grande">
                        {{ \App\Models\EvidenciaPago::whereDate('fecha_validacion', today())->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="g_fila">
        <div class="g_columna_6">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Evidencias por estado</h2>
                <canvas id="chartEvidenciaEstado"></canvas>
            </div>
        </div>

        <div class="g_columna_6">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Evidencias por proyecto</h2>
                <canvas id="chartProyecto"></canvas>
            </div>
        </div>
    </div>

    <div class="g_fila">
        <div class="g_panel">
            <h2 class="g_panel_titulo">Evidencias por fecha</h2>
            <canvas id="chartFecha"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {

        const colores = [
            '#4F46E5', '#3B82F6', '#10B981', '#F59E0B',
            '#EF4444', '#8B5CF6', '#EC4899', '#14B8A6'
        ];

        new Chart(document.getElementById('chartEvidenciaEstado'), {
            type: 'pie',
            data: {
                labels: @json($evidenciasPorEstado['labels']),
                datasets: [{
                    data: @json($evidenciasPorEstado['data']),
                    backgroundColor: colores,
                }]
            }
        });

    });

    new Chart(document.getElementById('chartProyecto'), {
        type: 'bar',
        data: {
            labels: @json($evidenciasPorProyecto['labels']),
            datasets: [{
                label: 'Evidencias',
                data: @json($evidenciasPorProyecto['data']),
                backgroundColor: '#3B82F6'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(document.getElementById('chartFecha'), {
        type: 'line',
        data: {
            labels: @json($evidenciasPorFecha['labels']),
            datasets: [{
                label: 'Evidencias',
                data: @json($evidenciasPorFecha['data']),
                borderColor: '#10B981',
                borderWidth: 2,
                fill: false,
                tension: 0.3
            }]
        }
    });
</script>
