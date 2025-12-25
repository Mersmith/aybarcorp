<div class="g_gap_pagina">

    <div class="g_fila g_panel">
        <div style="flex: 1 1 300px;">
            <h2 class="g_panel_titulo">Resumen</h2>

            <div class="g_fila" style="display: flex; flex-wrap: wrap; gap: 15px;">

                <div class="g_panel" style="flex: 1 1 150px; padding:15px; text-align:center;">
                    <h3 class="g_texto_gris">Total Tickets</h3>
                    <p class="g_numero_grande">{{ \App\Models\Ticket::count() }}</p>
                </div>

                <div class="g_panel" style="flex: 1 1 150px; padding:15px; text-align:center;">
                    <h3 class="g_texto_gris">Tickets Hoy</h3>
                    <p class="g_numero_grande">{{ \App\Models\Ticket::whereDate('created_at', today())->count() }}</p>
                </div>

                <div class="g_panel" style="flex: 1 1 150px; padding:15px; text-align:center;">
                    <h3 class="g_texto_gris">Prioridad Alta</h3>
                    <p class="g_numero_grande">{{ \App\Models\Ticket::where('prioridad_ticket_id',1)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="g_fila ">
        <div class="g_columna_4 g_gap_pagina">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Tickets por estado</h2>
                <canvas id="chartEstado" height="130"></canvas>
            </div>
        </div>

        <div class="g_columna_4 g_gap_pagina">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Tickets por canal</h2>
                <canvas id="grafCanal"></canvas>
            </div>
        </div>

        <div class="g_columna_4 g_gap_pagina">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Tickets por Tipo de Solicitud</h2>
                <canvas id="chartTipo" height="160"></canvas>
            </div>
        </div>
    </div>

    <div class="g_fila ">
        <div class="g_columna_6 g_gap_pagina">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Tickets por area</h2>
                <canvas id="chartArea" height="130"></canvas>
            </div>
        </div>
        <div class="g_columna_6 g_gap_pagina">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Ranking de usuarios que más cierran</h2>
                <canvas id="grafRankingUsuarios" height="150"></canvas>
            </div>
        </div>
    </div>

    <div class="g_panel">
        <h2 class="g_panel_titulo">Tickets por fecha</h2>
        <canvas id="chartFecha" height="130"></canvas>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {

    const colores = [
        '#4F46E5', '#3B82F6', '#10B981', '#F59E0B',
        '#EF4444', '#8B5CF6', '#EC4899', '#14B8A6'
    ];

    // PIE – Estados
    new Chart(document.getElementById('chartEstado'), {
        type: 'pie',
        data: {
            labels: @json($ticketsPorEstado['labels']),
            datasets: [{
                data: @json($ticketsPorEstado['data']),
                backgroundColor: colores,
            }]
        }
    });

    // BARRAS – Áreas
    new Chart(document.getElementById('chartArea'), {
        type: 'bar',
        data: {
            labels: @json($ticketsPorArea['labels']),
            datasets: [{
                label: "Tickets",
                data: @json($ticketsPorArea['data']),
                backgroundColor: colores,
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    // LÍNEA – Fechas
    new Chart(document.getElementById('chartFecha'), {
        type: 'line',
        data: {
            labels: @json($ticketsPorFecha['labels']),
            datasets: [{
                label: "Tickets por fecha",
                data: @json($ticketsPorFecha['data']),
                borderColor: '#3B82F6',
                borderWidth: 2,
                fill: false,
                tension: 0.3
            }]
        }
    });

    new Chart(document.getElementById('grafRankingUsuarios'), {
        type: 'bar',
        data: {
            labels: @json($rankingUsuarios['labels']),
            datasets: [{
                label: "Tickets cerrados",
                data: @json($rankingUsuarios['data']),
                backgroundColor: colores,
            }]
        },
        options: { indexAxis: 'y' }
    });

    new Chart(document.getElementById('grafCanal'), {
        type: 'pie',
        data: {
            labels: @json($ticketsPorCanal['labels']),
            datasets: [{
                data: @json($ticketsPorCanal['data']),
                backgroundColor: colores,
            }]
        }
    });

     new Chart(document.getElementById('chartTipo'), {
        type: 'pie',
        data: {
            labels: @json($ticketsPorTipo['labels'] ?? []),
            datasets: [{
                data: @json($ticketsPorTipo['data'] ?? []),
                backgroundColor: colores,
            }]
        },
        /*options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }*/
    });

});
</script>