<?php
// View for report: expects $this->data with 'reportRows' and 'metrics'
// $this->data can be an array or an object; adapt accordingly.
// Normalize data
$data = ($this->data) ? $this->data : [];
if (is_object($data)) {
  $reportRows = ($data->reportRows) ? $data->reportRows : [];
  $metrics = ($data->metrics) ? $data->metrics : [];
} else {
  $reportRows = ($data['reportRows']) ? $data['reportRows'] : [];
  $metrics = ($data['metrics']) ? $data['metrics'] : [];
}

function estadoLabel($estado, $defaultLabel = 'Desconocido')
{
  switch ((int) $estado) {
    case 1:
      return 'Pendiente';
    case 2:
      return 'Aprobado';
    case 3:
      return 'Rechazado';
    default:
      return $defaultLabel;
  }
}

// Prepare data for charts
$statusCounts = [
  'Pendiente' => ($metrics['pendientes']) ? (int) $metrics['pendientes'] : 0,
  'Aprobado' => ($metrics['aprobados']) ? (int) $metrics['aprobados'] : 0,
  'Rechazado' => ($metrics['rechazados']) ? (int) $metrics['rechazados'] : 0,
];

$approvedByUserCounts = [];
if (!empty($metrics['aprobados_por_usuario']) && is_array($metrics['aprobados_por_usuario'])) {
  $approvedByUserCounts = $metrics['aprobados_por_usuario'];
}

$createdByUserCounts = [];
if (!empty($metrics['creadas_por_usuario']) && is_array($metrics['creadas_por_usuario'])) {
  $createdByUserCounts = $metrics['creadas_por_usuario'];
}

// Totales por origen
$desdePublica = ($metrics['desde_publica']) ? (int) $metrics['desde_publica'] : 0;
$desdeAdmin = ($metrics['desde_admin']) ? (int) $metrics['desde_admin'] : 0;

?>
<h1 class="titulo-principal d-flex justify-content-between align-items-center">
  <span>
    <i class="fas fa-cogs"></i> Reporte de Solicitudes
  </span>
  <a class="btn btn-sm btn-success" href="?export=xls">Exportar XLS</a>
</h1>
<div class="container-fluid mt-4">
  <!--  <a class="btn btn-outline-secondary" href="?export=csv">Exportar CSV</a> -->
  <!-- Metrics (KPI cards) -->
  <div class="cards kpi-cards">
    <?php
    $cards = [
      ['key' => 'total', 'title' => 'Total', 'icon' => 'fas fa-tachometer-alt'],
      ['key' => 'aprobados', 'title' => 'Aprobados', 'icon' => 'fas fa-check-circle'],
      ['key' => 'rechazados', 'title' => 'Rechazados', 'icon' => 'fas fa-times-circle'],
      ['key' => 'pendientes', 'title' => 'Pendientes', 'icon' => 'fas fa-hourglass-half'],
    ];
    ?>

    <?php foreach ($cards as $c): ?>
      <div class="contenedor-card mb-4">
        <div class="card kpi-card kpi-card--<?= $c['key']; ?>">
          <div class="kpi-info">
            <h6 class="card-title card-title-metrics"><?= $c['title']; ?></h6>
            <p class="kpi-value">
              <?php if ($c['key'] === 'total'): ?>
                <?= ($metrics['total']) ? $metrics['total'] : count($reportRows); ?>
              <?php else: ?>
                <?= ($metrics[$c['key']]) ? $metrics[$c['key']] : 0; ?>
              <?php endif; ?>
            </p>
          </div>
          <div class="kpi-icon" aria-hidden="true">
            <i class="<?= $c['icon']; ?>"></i>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="contenedor-card mb-4">
      <div class="card kpi-card kpi-card--origen">
        <div class="kpi-info">
          <h6 class="card-title card-title-metrics">Origen</h6>
          <p class="kpi-value-small"><strong>Pública:</strong> <?= $desdePublica; ?><br>
            <strong>Administrador:</strong> <?= $desdeAdmin; ?>
          </p>
        </div>
        <div class="kpi-icon" aria-hidden="true">
          <i class="fas fa-globe"></i>
        </div>
      </div>
    </div>
  </div>


  <div class="row mb-4">
    <div class="col-md-6 mb-4">
      <div class="d-flex flex-column h-100" style="gap:12px;">
        <div class="card shadow-sm border-0">
          <div class="card-body chart-body">
            <h5 class="card-title mb-4 chart-title text-muted">Distribución por estado</h5>
            <div class="chart-container">
              <canvas id="statusChart" class="chart-canvas"></canvas>
            </div>
          </div>
        </div>
        <div class="card shadow-sm border-0">
          <div class="card-body table-body">
            <h5 class="card-title mb-4 chart-title text-muted">Últimas 10 Solicitudes</h5>
            <div class="table-responsive">
              <table class="table table-sm table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $last10 = array_slice($reportRows, -10);
                  $last10 = array_reverse($last10);
                  foreach ($last10 as $row): ?>
                    <tr>
                      <td><?= $row->solicitud_id; ?></td>
                      <td><?= $row->nombre_completo; ?></td>
                      <td>
                        <span class="badge 
                        <?php
                        switch ($row->estado) {
                          case 1:
                            echo 'bg-warning';
                            break;
                          case 2:
                            echo 'bg-success';
                            break;
                          case 3:
                            echo 'bg-danger';
                            break;
                          default:
                            echo 'bg-secondary';
                        }
                        ?>">
                          <?= $row->estado_label; ?>
                        </span>
                      </td>
                      <td><?= $row->fecha_ingreso ? date('d/m/Y', strtotime($row->fecha_ingreso)) : '-'; ?></td>
                    </tr>
                  <?php endforeach; ?>
                  <?php if (empty($last10)): ?>
                    <tr>
                      <td colspan="4" class="text-center text-muted">No hay solicitudes</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="d-flex flex-column h-100" style="gap:12px;">
        <div class="card shadow-sm border-0 flex-fill">
          <div class="card-body chart-body">
            <div class="chart-header mb-3">
              <h5 class="card-title chart-title text-muted">Aprobaciones por usuario</h5>
              <span id="approvedByUserMeta" class="chart-meta"></span>
            </div>
            <div class="chart-container chart-container--scroll" id="approvedByUserChartWrapper">
              <canvas id="approvedByUserChart" class="chart-canvas"></canvas>
            </div>
          </div>
        </div>

        <div class="card shadow-sm border-0 flex-fill">
          <div class="card-body chart-body">
            <div class="chart-header mb-3">
              <h5 class="card-title chart-title text-muted">Solicitudes creadas por usuario</h5>
              <span id="createdByUserMeta" class="chart-meta"></span>
            </div>
            <div class="chart-container chart-container--scroll" id="createdByUserChartWrapper">
              <canvas id="createdByUserChart" class="chart-canvas"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12">

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    function truncateText (text, maxLength) {
      if (typeof text !== 'string') {
        return '';
      }
      if (text.length <= maxLength) {
        return text;
      }
      return text.substring(0, maxLength - 1) + '...';
    }

    function prepareUserData (rawData) {
      const normalized = Object.entries(rawData || {})
        .map(function (entry) {
          return [entry[0], Number(entry[1]) || 0];
        })
        .filter(function (entry) {
          return entry[1] > 0;
        })
        .sort(function (a, b) {
          return b[1] - a[1];
        });

      if (!normalized.length) {
        return {
          labels: [],
          values: [],
          totalUsers: 0
        };
      }

      return {
        labels: normalized.map(function (entry) {
          return entry[0];
        }),
        values: normalized.map(function (entry) {
          return entry[1];
        }),
        totalUsers: normalized.length
      };
    }

    function setAdaptiveChartHeight (wrapperId, barsCount) {
      const wrapper = document.getElementById(wrapperId);
      if (!wrapper) {
        return;
      }

      const minHeight = 260;
      const maxHeight = 540;
      const rowHeight = 34;
      const estimatedHeight = Math.max(minHeight, (barsCount * rowHeight) + 40);

      if (estimatedHeight > maxHeight) {
        wrapper.style.height = maxHeight + 'px';
        wrapper.style.maxHeight = maxHeight + 'px';
        wrapper.style.overflowY = 'auto';
      } else {
        wrapper.style.height = estimatedHeight + 'px';
        wrapper.style.maxHeight = maxHeight + 'px';
        wrapper.style.overflowY = 'hidden';
      }
    }

    function createUserBarChart (config) {
      const canvas = document.getElementById(config.canvasId);
      if (!canvas) {
        return;
      }

      const ctx = canvas.getContext('2d');
      const processed = prepareUserData(config.rawData);
      const labels = processed.labels;
      const values = processed.values;
      const barsCount = labels.length || 1;

      setAdaptiveChartHeight(config.wrapperId, barsCount);

      const meta = document.getElementById(config.metaId);
      if (meta) {
        if (!processed.totalUsers) {
          meta.textContent = 'Sin datos para mostrar';
        } else {
          meta.textContent = 'Mostrando ' + processed.totalUsers + ' usuarios';
        }
      }

      const barGradient = ctx.createLinearGradient(0, 0, 300, 0);
      barGradient.addColorStop(0, config.gradientFrom);
      barGradient.addColorStop(1, config.gradientTo);

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: config.datasetLabel,
            data: values,
            borderRadius: 8,
            borderSkipped: false,
            maxBarThickness: 38,
            backgroundColor: barGradient
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                title: function (items) {
                  return items[0] ? items[0].label : '';
                },
                label: function (tooltipItem) {
                  return (tooltipItem.parsed.x || 0) + ' ' + config.tooltipSuffix;
                }
              }
            }
          },
          scales: {
            x: {
              beginAtZero: true,
              grid: { color: 'rgba(0,0,0,0.05)' },
              ticks: {
                precision: 0,
                stepSize: 1
              }
            },
            y: {
              grid: { display: false },
              ticks: {
                autoSkip: false,
                callback: function (value) {
                  const label = this.getLabelForValue(value);
                  return truncateText(label, 22);
                }
              }
            }
          }
        }
      });
    }

    const statusCanvas = document.getElementById('statusChart');
    const ctx = statusCanvas ? statusCanvas.getContext('2d') : null;
    if (ctx) {
      // pie with subtle stroke and legend at bottom
      const pieGrad = ctx.createLinearGradient(0, 0, 0, 150);
      pieGrad.addColorStop(0, 'rgba(255,255,255,0.05)');
      pieGrad.addColorStop(1, 'rgba(0,0,0,0.02)');

      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: <?= json_encode(array_keys($statusCounts)); ?>,
          datasets: [{
            data: <?= json_encode(array_values($statusCounts)); ?>,
            backgroundColor: ['#f0ad4e', '#5cb85c', '#d9534f'],
            borderWidth: 1,
            borderColor: 'rgba(255,255,255,0.6)'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                boxWidth: 12,
                padding: 12,
                usePointStyle: true,
                pointStyle: 'circle'
              }
            },
            tooltip: {
              callbacks: {
                label: function (ctx) {
                  const label = ctx.label || '';
                  const val = ctx.parsed || 0;
                  return label + ': ' + val;
                }
              }
            }
          }
        }
      });
    }

    createUserBarChart({
      canvasId: 'approvedByUserChart',
      wrapperId: 'approvedByUserChartWrapper',
      metaId: 'approvedByUserMeta',
      rawData: <?= json_encode($approvedByUserCounts); ?>,
      datasetLabel: 'Solicitudes aprobadas',
      tooltipSuffix: 'aprobadas',
      gradientFrom: '#6ee7b7',
      gradientTo: '#16a34a'
    });

    createUserBarChart({
      canvasId: 'createdByUserChart',
      wrapperId: 'createdByUserChartWrapper',
      metaId: 'createdByUserMeta',
      rawData: <?= json_encode($createdByUserCounts); ?>,
      datasetLabel: 'Solicitudes creadas',
      tooltipSuffix: 'creadas',
      gradientFrom: '#93c5fd',
      gradientTo: '#1e3a8a'
    });
  });

</script>

<style>
  .card-title-metrics {
    font-size: 0.875rem;
    font-weight: 600;
  }

  .card {
    /* min-height: 160px; */
    border-radius: 8px;
    transition: transform 0.2s ease-in-out;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .card-body.card-metric {
    display: grid;
    place-items: center;
  }

  .card-body.chart-body,
  .card-body.table-body {
    display: block;
  }

  .card-text-total {
    font-weight: 600;
    color: #2c3e50;
    font-size: 2.5rem;
  }

  .text-gray {
    color: #2c3e50;
  }

  .cards {
    display: flex;
    gap: 15px;
  }

  .contenedor-card {
    flex: 1;
  }

  .card-aprobados {
    border-left: 4px solid #28a745 !important;
  }

  .card-text-aprobados {
    font-weight: 600;
    color: #28a745;
    font-size: 2.5rem;
  }

  .card-rechazados {
    border-left: 4px solid #dc3545 !important;
  }

  .card-text-rechazados {
    font-weight: 600;
    color: #dc3545;
    font-size: 2.5rem;
  }

  .card-pendientes {
    border-left: 4px solid #ffc107 !important;
  }

  .card-text-pendientes {
    font-weight: 600;
    color: #f0ad4e;
    font-size: 2.5rem;
  }

  .chart-title {
    font-weight: 600;
    color: #2c3e50;

  }

  .chart-container {
    position: relative;
    width: 100%;
    height: 260px;
    max-height: 260px;
    padding: 8px 6px 4px 6px;
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(0, 0, 0, 0.01));
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(16, 24, 40, 0.04);
  }

  .chart-container--scroll {
    overflow-x: hidden;
    overflow-y: auto;
    scrollbar-width: thin;
  }

  .chart-container--scroll::-webkit-scrollbar {
    width: 8px;
  }

  .chart-container--scroll::-webkit-scrollbar-thumb {
    background: rgba(100, 116, 139, 0.45);
    border-radius: 999px;
  }

  .chart-header {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 10px;
  }

  .chart-meta {
    font-size: 0.78rem;
    color: #64748b;
    white-space: nowrap;
  }

  @media (max-width: 768px) {
    .chart-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 4px;
    }

    .chart-meta {
      white-space: normal;
    }
  }

  .chart-canvas {
    width: 100% !important;
    height: 100% !important;
  }

  /* Modern metric cards styles */
  .card-metric {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 1.25rem;
    border-radius: 12px;
    color: #fff;
  }

  .card-title-metrics {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.9);
  }

  .card .card-text.display-6,
  .card-text-total,
  .card-text-aprobados,
  .card-text-rechazados,
  .card-text-pendientes {
    font-size: 2.1rem;
    font-weight: 700;
    color: #fff;
  }

  .card {
    min-height: 160px;
    border-radius: 12px;
    transition: transform 0.18s ease, box-shadow 0.18s ease;
    overflow: hidden;
  }

  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(16, 24, 40, 0.12);
  }

  .card-aprobados {
    background: linear-gradient(135deg, rgba(34, 139, 34, 0.15) 0%, rgba(102, 187, 106, 0.06) 100%);
    color: #184d2b;
  }

  .card-rechazados {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.12) 0%, rgba(255, 123, 123, 0.04) 100%);
    color: #5b141c;
  }

  .card-pendientes {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(251, 211, 141, 0.04) 100%);
    color: #6a4b00;
  }

  .card-origen {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.12) 0%, rgba(96, 165, 250, 0.04) 100%);
    color: #15366a;
  }



  .card-text-muted-small {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.9);
  }

  /* KPI card styles */
  .kpi-cards {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
  }

  .kpi-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.1rem;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(16, 24, 40, 0.06);
    min-width: 200px;
    color: inherit;
    overflow: hidden;
    flex-direction: row;
  }

  .kpi-info {
    text-align: left;
  }

  .card-title-metrics {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: rgba(0, 0, 0, 0.55);
    margin: 0 0 6px 0;
  }

  .kpi-value {
    font-size: 1.9rem;
    font-weight: 800;
    margin: 0;
    color: #0f172a;
  }

  .kpi-value-small {
    font-size: 1rem;
    margin: 0;
    color: #0f172a;
  }

  .kpi-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(16, 24, 40, 0.06);
    flex-shrink: 0;
  }

  .kpi-icon i {
    font-size: 1.4rem;
    color: var(--kpi-icon-color, #111827);
  }

  .kpi-card--aprobados .kpi-icon {
    background: rgba(40, 167, 69, 0.12);
    --kpi-icon-color: #28a745;
  }

  .kpi-card--aprobados .kpi-value {
    color: #166534;
  }

  .kpi-card--rechazados .kpi-icon {
    background: rgba(220, 53, 69, 0.12);
    --kpi-icon-color: #dc3545;
  }

  .kpi-card--rechazados .kpi-value {
    color: #7f1d1d;
  }

  .kpi-card--pendientes .kpi-icon {
    background: rgba(245, 158, 11, 0.12);
    --kpi-icon-color: #d97706;
  }

  .kpi-card--pendientes .kpi-value {
    color: #92400e;
  }

  .kpi-card--total .kpi-icon {
    background: rgba(107, 114, 128, 0.12);
    --kpi-icon-color: #6b7280;
  }

  .kpi-card--total .kpi-value {
    color: #0f172a;
  }

  .kpi-card--origen .kpi-icon {
    background: rgba(37, 99, 235, 0.12);
    --kpi-icon-color: #2563eb;
  }

  .kpi-card--origen .kpi-value-small {
    color: #15366a;
  }
</style>