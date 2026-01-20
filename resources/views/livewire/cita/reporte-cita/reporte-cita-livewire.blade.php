<div class="g_gap_pagina">

    <div class="g_fila">
        <div class="g_columna_4">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Citas por estado</h2>
                <canvas id="chartEstado"></canvas>
            </div>
        </div>

        <div class="g_columna_4">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Citas por sede</h2>
                <canvas id="chartSede"></canvas>
            </div>
        </div>

        <div class="g_columna_4">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Motivo de citas</h2>
                <canvas id="chartMotivo"></canvas>
            </div>
        </div>
    </div>

    <div class="g_panel">
        <h2 class="g_panel_titulo">Citas por fecha</h2>
        <canvas id="chartFecha"></canvas>
    </div>

    <div class="g_panel">
        <h2 class="g_panel_titulo">Ranking usuarios que atienden más</h2>
        <canvas id="chartRanking"></canvas>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {

    const colores = ['#4F46E5','#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#14B8A6'];

    new Chart(document.getElementById('chartEstado'), {
        type: 'pie',
        data: {
            labels: @json($porEstado['labels']),
            datasets: [{
                data: @json($porEstado['data']),
                backgroundColor: colores,
            }]
        }
    });

    new Chart(document.getElementById('chartSede'), {
        type: 'bar',
        data: {
            labels: @json($porSede['labels']),
            datasets: [{
                label: "Citas",
                data: @json($porSede['data']),
                backgroundColor: colores,
            }]
        }
    });

    new Chart(document.getElementById('chartMotivo'), {
        type: 'pie',
        data: {
            labels: @json($porMotivo['labels']),
            datasets: [{
                data: @json($porMotivo['data']),
                backgroundColor: colores,
            }]
        }
    });

    new Chart(document.getElementById('chartFecha'), {
        type: 'line',
        data: {
            labels: @json($porFecha['labels']),
            datasets: [{
                label: "Citas por fecha",
                data: @json($porFecha['data']),
                borderColor: '#3B82F6',
                borderWidth: 2,
                fill: false,
                tension: 0.3
            }]
        }
    });

    new Chart(document.getElementById('chartRanking'), {
        type: 'bar',
        data: {
            labels: @json($rankingUsuarios['labels']),
            datasets: [{
                label: "Atenciones",
                data: @json($rankingUsuarios['data']),
                backgroundColor: colores,
            }]
        },
        options: { indexAxis: 'y' }
    });

});
</script>