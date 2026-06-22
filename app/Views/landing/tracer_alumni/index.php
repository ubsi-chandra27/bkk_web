<?= $this->extend('landing/layout/app') ?>

<?php
$jsonOptions = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;
$topBidangDudiJson = json_encode($top_bidang_dudi ?? [], $jsonOptions);
$statusAlumniJson = json_encode($status_alumni ?? [], $jsonOptions);
$isAlumni = (string) session()->get('role') === '4'
    || (string) session()->get('id_role') === '4'
    || strtolower((string) session()->get('role')) === 'alumni';
?>

<?= $this->section('hero-section') ?>
<div class="d-flex flex-column flex-center w-100 min-h-200px min-h-lg-300px px-9 text-center">
    <div class="container">
        <div class="tracer-hero-header">
            <div>
                <span class="tracer-hero-eyebrow">
                    <i class="fa-solid fa-graduation-cap"></i>
                    BKK Tracer Study
                </span>
                <h1 class="text-white fw-bolder fs-2hx mb-3">Tracer Alumni</h1>
                <p class="text-white fw-semibold fs-5 opacity-75 mb-0">
                    Data jejak karir dan studi lanjut alumni
                </p>
            </div>

            <?php if ($isAlumni): ?>
                <a href="<?= site_url('tracer-study') ?>" class="btn btn-primary tracer-update-btn">
                    <i class="fa-solid fa-pen-to-square me-2"></i>
                    Perbarui Data Saya
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="tracer-page">
    <div class="container py-12 py-lg-15">
        <div class="tracer-stats-grid">
            <div class="tracer-stat-card">
                <div class="tracer-stat-icon tracer-stat-blue">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div>
                    <div class="tracer-stat-value"><?= number_format((int) ($total_bekerja ?? 0), 0, ',', '.') ?></div>
                    <div class="tracer-stat-label">Tingkat Bekerja</div>
                    <div class="tracer-stat-unit">alumni</div>
                </div>
            </div>

            <div class="tracer-stat-card">
                <div class="tracer-stat-icon tracer-stat-green">
                    <i class="fa-solid fa-store"></i>
                </div>
                <div>
                    <div class="tracer-stat-value"><?= number_format((int) ($total_wirausaha ?? 0), 0, ',', '.') ?></div>
                    <div class="tracer-stat-label">Wirausaha</div>
                    <div class="tracer-stat-unit">alumni</div>
                </div>
            </div>

            <div class="tracer-stat-card">
                <div class="tracer-stat-icon tracer-stat-orange">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <div>
                    <div class="tracer-stat-value"><?= number_format((int) ($total_studi ?? 0), 0, ',', '.') ?></div>
                    <div class="tracer-stat-label">Studi Lanjut</div>
                    <div class="tracer-stat-unit">alumni</div>
                </div>
            </div>

            <div class="tracer-stat-card">
                <div class="tracer-stat-icon tracer-stat-violet">
                    <i class="fa-solid fa-link"></i>
                </div>
                <div>
                    <div class="tracer-stat-value"><?= number_format((float) ($pct_relevan ?? 0), 1, ',', '.') ?>%</div>
                    <div class="tracer-stat-label">Relevan Jurusan</div>
                    <div class="tracer-stat-unit">kesesuaian</div>
                </div>
            </div>
        </div>

        <div class="tracer-chart-grid">
            <section class="tracer-panel">
                <div class="tracer-panel-header">
                    <div>
                        <h2>Bidang Pekerjaan</h2>
                        <p>5 bidang DUDI terbanyak dari alumni yang bekerja</p>
                    </div>
                </div>
                <div class="tracer-chart-wrap">
                    <canvas id="chartBidangDudi" aria-label="Grafik bidang pekerjaan" role="img"></canvas>
                    <?php if (empty($top_bidang_dudi)): ?>
                        <div class="tracer-empty-chart">Belum ada data bidang pekerjaan yang disetujui.</div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="tracer-panel">
                <div class="tracer-panel-header">
                    <div>
                        <h2>Status Alumni</h2>
                        <p>Distribusi status kegiatan alumni</p>
                    </div>
                </div>
                <div class="tracer-chart-wrap">
                    <canvas id="chartStatusAlumni" aria-label="Grafik status alumni" role="img"></canvas>
                    <?php if (empty($status_alumni)): ?>
                        <div class="tracer-empty-chart">Belum ada data status alumni yang disetujui.</div>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <section class="tracer-panel tracer-company-panel">
            <div class="tracer-panel-header">
                <div>
                    <h2>Perusahaan Teratas</h2>
                    <p>DUDI yang paling banyak menjadi tujuan alumni</p>
                </div>
            </div>

            <?php if (!empty($top_perusahaan)): ?>
                <div class="tracer-company-grid">
                    <?php foreach ($top_perusahaan as $company): ?>
                        <div class="tracer-company-item">
                            <div class="tracer-company-mark">
                                <?= esc(strtoupper(substr((string) ($company['label'] ?? 'D'), 0, 1))) ?>
                            </div>
                            <div class="tracer-company-name"><?= esc($company['label'] ?? '-') ?></div>
                            <div class="tracer-company-total"><?= number_format((int) ($company['total'] ?? 0), 0, ',', '.') ?> alumni</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="tracer-empty-list">Belum ada data perusahaan yang disetujui.</div>
            <?php endif; ?>
        </section>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .tracer-page {
        background: #f7f9fc;
    }

    .tracer-hero-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 24px;
        text-align: center;
    }

    .tracer-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 999px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 16px;
        backdrop-filter: blur(8px);
    }

    .tracer-update-btn {
        white-space: nowrap;
    }

    .tracer-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .tracer-stat-card,
    .tracer-panel {
        background: #ffffff;
        border: 1px solid #e6eaf2;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(31, 44, 71, 0.06);
    }

    .tracer-stat-card {
        display: flex;
        align-items: center;
        gap: 16px;
        min-height: 132px;
        padding: 22px;
    }

    .tracer-stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        border-radius: 8px;
        font-size: 22px;
        flex: 0 0 52px;
    }

    .tracer-stat-blue {
        color: #1b84ff;
        background: #eef6ff;
    }

    .tracer-stat-green {
        color: #17a673;
        background: #eafaf3;
    }

    .tracer-stat-orange {
        color: #f59e0b;
        background: #fff7e6;
    }

    .tracer-stat-violet {
        color: #7c3aed;
        background: #f3efff;
    }

    .tracer-stat-value {
        color: #181c32;
        font-size: 30px;
        line-height: 1;
        font-weight: 800;
    }

    .tracer-stat-label {
        color: #3f4254;
        font-size: 14px;
        font-weight: 700;
        margin-top: 8px;
    }

    .tracer-stat-unit {
        color: #8a92a6;
        font-size: 12px;
        font-weight: 600;
        margin-top: 2px;
    }

    .tracer-chart-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px;
        margin-bottom: 24px;
    }

    .tracer-panel {
        padding: 24px;
    }

    .tracer-panel-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .tracer-panel-header h2 {
        color: #181c32;
        font-size: 20px;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .tracer-panel-header p {
        color: #7e8299;
        font-size: 13px;
        font-weight: 500;
        margin: 0;
    }

    .tracer-chart-wrap {
        position: relative;
        min-height: 300px;
    }

    .tracer-chart-wrap canvas {
        width: 100% !important;
        height: 300px !important;
    }

    .tracer-empty-chart,
    .tracer-empty-list {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 160px;
        color: #8a92a6;
        background: #f8fafc;
        border: 1px dashed #d7deea;
        border-radius: 8px;
        font-weight: 600;
        text-align: center;
        padding: 18px;
    }

    .tracer-company-panel {
        margin-bottom: 8px;
    }

    .tracer-company-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .tracer-company-item {
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr);
        grid-template-areas:
            "mark name"
            "mark total";
        align-items: center;
        gap: 4px 12px;
        padding: 16px;
        border: 1px solid #edf0f5;
        border-radius: 8px;
        background: #fbfcfe;
    }

    .tracer-company-mark {
        grid-area: mark;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        color: #1f2a44;
        background: #e9edf5;
        border-radius: 8px;
        font-weight: 800;
    }

    .tracer-company-name {
        grid-area: name;
        color: #181c32;
        font-size: 14px;
        font-weight: 800;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .tracer-company-total {
        grid-area: total;
        color: #7e8299;
        font-size: 12px;
        font-weight: 700;
    }

    @media (max-width: 1199.98px) {
        .tracer-stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .tracer-company-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .tracer-update-btn {
            width: 100%;
            max-width: 320px;
        }

        .tracer-stats-grid,
        .tracer-chart-grid,
        .tracer-company-grid {
            grid-template-columns: 1fr;
        }

        .tracer-stat-card {
            min-height: 112px;
            padding: 18px;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    "use strict";

    const bidangDudiData = <?= $topBidangDudiJson ?: '[]' ?>;
    const statusAlumniData = <?= $statusAlumniJson ?: '[]' ?>;

    const chartPalette = {
        primary: '#1b84ff',
        green: '#17a673',
        violet: '#7F77DD',
        teal: '#1ecab8',
        orange: '#ffb800',
        yellow: '#ffc107',
        gray: '#6c757d',
        grid: '#edf0f5',
        text: '#667085'
    };

    function toChartData(rows) {
        return {
            labels: rows.map((item) => item.label || '-'),
            values: rows.map((item) => Number(item.total || item.value || 0))
        };
    }

    function createHorizontalBar(canvasId, rows, color) {
        const canvas = document.getElementById(canvasId);
        if (!canvas || !rows.length || typeof Chart === 'undefined') {
            return;
        }

        const data = toChartData(rows);

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.values,
                    backgroundColor: color,
                    borderRadius: 6,
                    borderSkipped: false,
                    barThickness: 22
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.x + ' alumni';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: chartPalette.text
                        },
                        grid: {
                            color: chartPalette.grid
                        }
                    },
                    y: {
                        ticks: {
                            color: chartPalette.text,
                            font: {
                                weight: '600'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    function createPieChart(canvasId, rows) {
        const canvas = document.getElementById(canvasId);
        if (!canvas || !rows.length || typeof Chart === 'undefined') {
            return;
        }

        const data = toChartData(rows);
        const total = data.values.reduce((a, b) => a + b, 0);

        const colorMap = {
            'Bekerja': chartPalette.primary,
            'Kuliah': chartPalette.green,
            'Wirausaha': chartPalette.yellow,
            'Belum Bekerja': chartPalette.gray
        };

        const backgroundColors = data.labels.map(label => colorMap[label] || chartPalette.gray);

        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.values,
                    backgroundColor: backgroundColors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: chartPalette.text,
                            font: {
                                size: 12
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return context.label + ': ' + value + ' alumni (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        createHorizontalBar('chartBidangDudi', bidangDudiData, chartPalette.primary);
        createPieChart('chartStatusAlumni', statusAlumniData);
    });
</script>
<?= $this->endSection() ?>