<div class="g_gap_pagina">
    <div class="g_fila">
        <div class="g_columna_12">
            <div class="g_panel">
                <h2 class="g_panel_titulo">Clientes nuevos por día</h2>

                <div class="formulario">
                    <div class="g_columna_3">
                        <label>Seleccionar mes</label>
                        <input type="month" class="g_input" wire:model.live="mesSeleccionado" required>
                    </div>
                </div>

                <div wire:ignore>
                    <canvas id="chartDiaMes" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let chartDiaMes = null;

    document.addEventListener('livewire:init', () => {

        const ctx = document.getElementById('chartDiaMes');

        chartDiaMes = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($clientesPorDiaMesActual['labels']),
                datasets: [{
                    label: 'Clientes nuevos',
                    data: @json($clientesPorDiaMesActual['data']),
                    borderColor: '#10B981',
                    tension: 0.3,
                    pointRadius: 4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                animation: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        Livewire.on('actualizarGraficoDiaMes', (payload) => {
            console.log(payload);
            const data = payload[0];

            chartDiaMes.data.labels = data.labels;
            chartDiaMes.data.datasets[0].data = data.data;
            chartDiaMes.update();
        });
    });
</script>
