<div class="g_gap_pagina">

    <div class="g_fila">
        <div class="g_panel_4_grid">

            <div class="g_panel">
                <div class="g_panel_dashboard">
                    <div>
                        <h2>Total Evidencias</h2>
                        <p class="g_negrita">{{ $totalEvidencias }}</p>
                    </div>
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
            </div>

            <div class="g_panel">
                <div class="g_panel_dashboard">
                    <div>
                        <h2>Validadas</h2>
                        <p class="g_negrita">{{ $evidenciasValidadas['data'][0] }}</p>
                    </div>
                    <i class="fa-solid fa-check-circle"></i>
                </div>
            </div>

            <div class="g_panel">
                <div class="g_panel_dashboard">
                    <div>
                        <h2>Pendientes</h2>
                        <p class="g_negrita">{{ $evidenciasValidadas['data'][1] }}</p>
                    </div>
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>

            <div class="g_panel">
                <div class="g_panel_dashboard">
                    <div class="g_panel_dashboard_1">
                        <h2>Sin gestor</h2>
                        <p class="g_negrita">{{ $evidenciasSinAsignar }}</p>
                    </div>
                    <i class="fa-solid fa-user-tie"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="g_fila">
        <div class="g_columna_12">
            <div class="g_panel">
                <h2>Evidencias por Fecha</h2>
                <canvas id="chartPorFecha" height="140"></canvas>
            </div>
        </div>
    </div>

    <div class="g_fila">
        <div class="g_columna_12">
            <div class="g_panel">
                <h2>Evidencias por Unidad de Negocio</h2>
                <canvas id="chartPorUnidad" height="150"></canvas>
            </div>
        </div>
    </div>

    <div class="g_fila">
        <div class="g_columna_12">
            <div class="g_panel">
                <h2>Evidencias por Proyecto</h2>
                <canvas id="chartPorProyecto" height="140"></canvas>
            </div>
        </div>
    </div>

    <div class="g_fila">
        <div class="g_columna_12">
            <div class="g_panel">
                <h2>Top Gestores - Solicitudes Validadas</h2>
                <canvas id="chartTopGestores" height="150"></canvas>
            </div>
        </div>
    </div>

    <div class="g_fila">
        <div class="g_columna_4">
            <div class="g_panel">
                <h2>Evidencias por Estado</h2>
                <canvas id="chartPorEstado" height="180"></canvas>
            </div>
        </div>

        <div class="g_columna_4">
            <div class="g_panel">
                <h2>Solicitudes Asignadas vs Sin Asignar</h2>
                <canvas id="chartAsignacion" height="150"></canvas>
            </div>
        </div>

        <div class="g_columna_4">
            <div class="g_panel">
                <h2>Solicitudes Validadas vs Pendientes</h2>
                <canvas id="chartValidadas" height="150"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('livewire:init', () => {

    const colores = ['#4F46E5', '#3B82F6', '#10B981', '#F59E0B', '#EF4444'];

    new Chart(document.getElementById('chartPorEstado'), {
        type: 'pie',
        data: {
            labels: @json($evidenciasPorEstado['labels']),
            datasets: [{
                data: @json($evidenciasPorEstado['data']),
                backgroundColor: colores
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    new Chart(document.getElementById('chartPorUnidad'), {
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
    });

    new Chart(document.getElementById('chartPorProyecto'), {
        type: 'bar',
        data: {
            labels: @json($evidenciasPorProyecto['labels']),
            datasets: [{
                label: 'Evidencias',
                data: @json($evidenciasPorProyecto['data']),
                backgroundColor: colores
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('chartPorFecha'), {
        type: 'line',
        data: {
            labels: @json($evidenciasPorFecha['labels']),
            datasets: [{
                label: 'Evidencias',
                data: @json($evidenciasPorFecha['data']),
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79,70,229,0.2)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('chartTopGestores'), {
            type: 'bar',
            data: {
                labels: @json($topGestores['labels']),
                datasets: [{
                    label: 'Solicitudes validadas',
                    data: @json($topGestores['data']),
                    backgroundColor: colores,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
    });

    new Chart(document.getElementById('chartAsignacion'), {
        type: 'pie',
        data: {
            labels: ['Asignadas', 'Sin asignar'],
            datasets: [{
                data: [{{ $evidenciasAsignadas }}, {{ $evidenciasSinAsignar }}],
                backgroundColor: colores,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    new Chart(document.getElementById('chartValidadas'), {
        type: 'pie',
        data: {
            labels: @json($evidenciasValidadas['labels']),
            datasets: [{
                data: @json($evidenciasValidadas['data']),
                backgroundColor: colores
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

});
</script>