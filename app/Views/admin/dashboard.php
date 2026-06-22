<?= $this->extend('admin/layout/app') ?>

<?= $this->section('content') ?>

<!--begin::Container-->
<div id="kt_content_container" class="container-xxl py-6">

    <!--begin::Header Dashboard-->
    <div class="row mb-6">
        <div class="col-12">
            <div class="card border-0  shadow-sm">
                <div class="card-body p-5 p-lg-6">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between">
                        <div class="mb-4 mb-lg-0">
                            <h1 class="text-gray-900 fw-bold mb-2 display-6">
                                <?= $userRole == 1 ? 'Selamat Datang, Super Admin' : ($userRole == 2 ? 'Selamat Datang, Admin BKK' : 'Selamat Datang') ?>
                            </h1>
                            <p class="text-gray-600 fs-5 mb-0">Berikut ringkasan data terbaru sistem BKK & Tracer Study</p>
                        </div>
                        <div class="text-lg-end">
                            <div class="d-flex align-items-center justify-content-lg-end">
                                <span class="svg-icon svg-icon-primary svg-icon-2hx me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M19 3H5C4 3 3 4 3 5V19C3 20 4 21 5 21H19C20 21 21 20 21 19V5C21 4 20 3 19 3ZM19 19H5V5H19V19ZM11 7H13V13H11V7ZM11 15H13V17H11V15Z" fill="currentColor" fill-opacity="0.3" />
                                        <path d="M7 7H9V9H7V7ZM7 11H9V13H7V11ZM13 7H15V9H13V7ZM13 11H15V13H13V11Z" fill="currentColor" />
                                        <path d="M17 7H19V9H17V7ZM17 11H19V13H17V11Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-muted fw-bold mb-1">Tanggal Hari Ini</p>
                                    <p class="text-dark fw-bold fs-3 mb-0"><?= date('d F Y') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Header Dashboard-->

    <!--begin::Statistik Utama (4 Cards)-->
    <div class="row g-4 mb-6">

        <!-- Alumni -->
        <div class="col-xl-3 col-lg-6">
            <a href="<?= base_url('admin/data-tracer') ?>" class="card stat-card-custom h-100 border-0 shadow-sm hoverable">
                <div class="top-accent" style="background:#7F77DD;"></div>
                <div class="card-body pt-7">
                    <div class="icon-box mb-4" style="background:#EEEDFE;">
                        <i class="fa-solid fa-user-graduate" style="color:#3C3489;font-size:18px;"></i>
                    </div>
                    <div class="text-muted fw-semibold fs-7 text-uppercase ls-1 mb-1">Total Alumni</div>
                    <div class="text-gray-900 fs-2hx fw-bolder mb-2"><?= number_format($totalAlumni) ?></div>
                    <div class="d-flex align-items-center gap-2">
                        <?php if ($alumniLastMonth > 0): ?>
                            <span class="stat-badge" style="background:#EEEDFE;color:#3C3489;">+<?= number_format($alumniLastMonth) ?></span>
                            <span class="text-muted fs-8">dari bulan lalu</span>
                        <?php else: ?>
                            <span class="text-muted fs-8">Data terbaru</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </div>

        <!-- Perusahaan -->
        <div class="col-xl-3 col-lg-6">
            <a href="<?= base_url('admin/data-perusahaan') ?>" class="card stat-card-custom h-100 border-0 shadow-sm hoverable">
                <div class="top-accent" style="background:#1D9E75;"></div>
                <div class="card-body pt-7">
                    <div class="icon-box mb-4" style="background:#E1F5EE;">
                        <i class="fa-solid fa-building" style="color:#085041;font-size:18px;"></i>
                    </div>
                    <div class="text-muted fw-semibold fs-7 text-uppercase ls-1 mb-1">Total Perusahaan</div>
                    <div class="text-gray-900 fs-2hx fw-bolder mb-2"><?= number_format($totalPerusahaan) ?></div>
                    <div class="d-flex align-items-center gap-2">
                        <?php if ($newCompaniesLastMonth > 0): ?>
                            <span class="stat-badge" style="background:#E1F5EE;color:#085041;">+<?= number_format($newCompaniesLastMonth) ?></span>
                            <span class="text-muted fs-8">perusahaan baru</span>
                        <?php else: ?>
                            <span class="text-muted fs-8">Perusahaan terdaftar</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </div>

        <!-- Lowongan -->
        <div class="col-xl-3 col-lg-6">
            <a href="<?= base_url('admin/data-lowongan') ?>" class="card stat-card-custom h-100 border-0 shadow-sm hoverable">
                <div class="top-accent" style="background:#378ADD;"></div>
                <div class="card-body pt-7">
                    <div class="icon-box mb-4" style="background:#E6F1FB;">
                        <i class="fa-solid fa-briefcase" style="color:#0C447C;font-size:18px;"></i>
                    </div>
                    <div class="text-muted fw-semibold fs-7 text-uppercase ls-1 mb-1">Total Lowongan</div>
                    <div class="text-gray-900 fs-2hx fw-bolder mb-2"><?= number_format($totalLowongan) ?></div>
                    <div class="d-flex align-items-center gap-2">
                        <?php if ($newJobsToday > 0): ?>
                            <span class="stat-badge" style="background:#E6F1FB;color:#0C447C;"><?= number_format($newJobsToday) ?> aktif</span>
                        <?php else: ?>
                            <span class="text-muted fs-8">Lowongan ditampilkan</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pelamar -->
        <div class="col-xl-3 col-lg-6">
            <a href="<?= base_url('admin/data-pelamar') ?>" class="card stat-card-custom h-100 border-0 shadow-sm hoverable">
                <div class="top-accent" style="background:#EF9F27;"></div>
                <div class="card-body pt-7">
                    <div class="icon-box mb-4" style="background:#FAEEDA;">
                        <i class="fa-solid fa-user-group" style="color:#633806;font-size:18px;"></i>
                    </div>
                    <div class="text-muted fw-semibold fs-7 text-uppercase ls-1 mb-1">Total Pelamar</div>
                    <div class="text-gray-900 fs-2hx fw-bolder mb-2"><?= number_format($totalPelamar) ?></div>
                    <div class="d-flex align-items-center gap-2">
                        <?php if ($newPelamarToday > 0): ?>
                            <span class="stat-badge" style="background:#FAEEDA;color:#633806;">+<?= number_format($newPelamarToday) ?></span>
                            <span class="text-muted fs-8">hari ini</span>
                        <?php else: ?>
                            <span class="text-muted fs-8">Pendaftar tertulis</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </div>

    </div>
    <!--end::Statistik Utama-->

    <div class="row g-5 g-xl-8">
        <!--begin::Col Grafik Tracer Study (Line Chart)-->
        <div class="col-xl-8">
            <div class="card card-stretch h-100 border-0 shadow-sm ">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title fw-bold text-gray-900 fs-4">Grafik Tracer Study</h3>
                </div>
                <div class="card-body">
                    <div id="tracerChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>
        <!--end::Col Grafik Tracer Study-->

        <!--begin::Col Status Alumni (Pie Chart)-->
        <div class="col-xl-4">
            <div class="card card-stretch h-100 border-0 shadow-sm">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title fw-bold text-gray-900 fs-4">Status Alumni</h3>
                </div>
                <div class="card-body">
                    <div id="statusAlumniChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>
        <!--end::Col Status Alumni-->
    </div>

    <!--begin::Perusahaan Aktif & Data Tracer Terbaru-->
    <div class="row g-5 g-xl-8 mt-4">
        <!--begin::Col Perusahaan Aktif-->
        <div class="col-xl-4">
            <div class="card card-stretch h-100 border-0 shadow-sm" id="perusahaan-aktif-card">
                <div class="card-header border-0 pt-6">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title fw-bold text-gray-900 fs-4">Perusahaan Aktif</h3>
                        <a href="<?= base_url('admin/data-perusahaan') ?>" class="btn btn-sm btn-light-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($perusahaanAktif)): ?>
                        <div class="text-center py-12">
                            <span class="svg-icon svg-icon-5hx text-gray-300 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M19 3H5C4 3 3 4 3 5V19C3 20 4 21 5 21H19C20 21 21 20 21 19V5C21 4 20 3 19 3ZM19 19H5V5H19V19ZM11 7H13V13H11V7ZM11 15H13V17H11V15Z" fill="currentColor" fill-opacity="0.3" />
                                    <path d="M7 7H9V9H7V7ZM7 11H9V13H7V11ZM13 7H15V9H13V7ZM13 11H15V13H13V11Z" fill="currentColor" />
                                    <path d="M17 7H19V9H17V7ZM17 11H19V13H17V11Z" fill="currentColor" />
                                </svg>
                            </span>
                            <p class="text-gray-500">Belum ada perusahaan aktif</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($perusahaanAktif as $perusahaan): ?>
                                <div class="list-group-item list-group-item-light py-4 px-0 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50px symbol-circle me-4">
                                            <?php if (!empty($perusahaan['logo'])): ?>
                                                <img src="<?= base_url('uploads/logo/' . $perusahaan['logo']) ?>" alt="Logo" class=" object-cover rounded-circle" />
                                            <?php else: ?>
                                                <span class="symbol-label bg-light-primary text-primary fs-4 fw-bold">
                                                    <?= strtoupper(substr($perusahaan['nama_perusahaan'] ?? 'P', 0, 1)) ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="text-gray-900 fw-bold mb-1"><?= esc($perusahaan['nama_perusahaan']) ?></h6>
                                            <span class="badge bg-light-primary text-primary fw-bold px-3 py-2">
                                                <?= number_format($perusahaan['jumlah_lowongan'] ?? 0) ?> Lowongan Aktif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!--end::Col Perusahaan Aktif-->

        <!--begin::Col Data Tracer Study Terbaru-->
        <div class="col-xl-8">
            <div class="card card-stretch h-100 border-0 shadow-sm">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title fw-bold text-gray-900 fs-4">Data Tracer Study Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($tracerTerbaru)): ?>
                        <div class="text-center py-12">
                            <span class="svg-icon svg-icon-5hx text-gray-300 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M19 3H5C4 3 3 4 3 5V19C3 20.1 4 21 5 21H19C20.1 21 21 20.1 21 19V5C21 4.9 20.1 4 19 4H19V3Z" fill="currentColor" fill-opacity="0.3" />
                                    <path d="M11 7L13 9L7 15L3 11L11 7Z" fill="currentColor" />
                                </svg>
                            </span>
                            <p class="text-gray-500">Belum ada data tracer study</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle gy-6">
                                <thead class="text-muted fw-bold fs-7 text-uppercase bg-light-primary bg-opacity-50">
                                    <tr>
                                        <th class="text-center ps-4">Nama Alumni</th>
                                        <th class="text-center">Angkatan</th>
                                        <th class="text-center">Jurusan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Pekerjaan/Instansi</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-7">
                                    <?php foreach ($tracerTerbaru as $tracer): ?>
                                        <tr class="border-bottom border-gray-200">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-40px symbol-circle me-3">
                                                        <span class="symbol-label bg-light-success text-success fs-6 fw-bold">
                                                            <?= strtoupper(substr($tracer['nama_alumni'] ?? 'A', 0, 2)) ?>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-900 fw-bold"><?= esc($tracer['nama_alumni']) ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-gray-700"><?= esc($tracer['angkatan']) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-gray-600"><?= esc($tracer['jurusan']) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $statusClass = match (strtolower($tracer['status_aktivitas'] ?? '')) {
                                                    'bekerja' => 'bg-light-success text-success',
                                                    'kuliah' => 'bg-light-primary text-primary',
                                                    'wirausaha' => 'bg-light-info text-info',
                                                    default => 'bg-light-warning text-warning',
                                                };
                                                ?>
                                                <span class="badge <?= $statusClass ?> fw-bold px-3 py-2">
                                                    <?= esc($tracer['status_aktivitas']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-gray-600">
                                                    <?= esc($tracer['posisi_kerja'] ?? $tracer['nama_dudi'] ?? $tracer['nama_usaha'] ?? '-') ?>
                                                </span>
                                            </td>
                                            <td class="text-center pe-4">
                                                <a href="<?= base_url('admin/data-tracer/show/' . $tracer['id']) ?>" class="btn btn-sm btn-light-primary btn-active-light-primary fw-bold">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!--end::Col Data Tracer Study Terbaru-->
    </div>
    <!--end::Perusahaan Aktif & Data Tracer Terbaru-->

    <!--begin::Insight Tambahan (Optional)-->
    <div class="row g-5 g-xl-8 mt-4">
        <div class="col-xl-12">
            <div class="row g-5">
                <!-- Tingkat Bekerja -->
                <div class="col-md-4">
                    <div class="card card-stretch h-100 border-0 bg-light-success bg-opacity-10 shadow-sm">
                        <div class="card-body text-center">
                            <?php
                            $workingCount = 0;
                            foreach ($statusAlumniData as $item) {
                                if (stripos($item['label'], 'bekerja') !== false) {
                                    $workingCount = $item['value'];
                                    break;
                                }
                            }
                            $totalCount = array_sum(array_column($statusAlumniData, 'value'));
                            $workingPercentage = $totalCount > 0 ? round(($workingCount / $totalCount) * 100, 1) : 0;
                            ?>
                            <div class="text-success fs-1 fw-bolder mb-2"><?= $workingPercentage ?>%</div>
                            <div class="text-gray-700 fw-bold">Tingkat Bekerja</div>
                            <div class="text-muted fs-8">Alumni yang sudah bekerja</div>
                        </div>
                    </div>
                </div>

                <!-- Melanjutkan Kuliah -->
                <div class="col-md-4">
                    <div class="card card-stretch h-100 border-0 bg-light-primary bg-opacity-10 shadow-sm">
                        <div class="card-body text-center">
                            <?php
                            $collegeCount = 0;
                            foreach ($statusAlumniData as $item) {
                                if (stripos($item['label'], 'kuliah') !== false) {
                                    $collegeCount = $item['value'];
                                    break;
                                }
                            }
                            $collegePercentage = $totalCount > 0 ? round(($collegeCount / $totalCount) * 100, 1) : 0;
                            ?>
                            <div class="text-primary fs-1 fw-bolder mb-2"><?= $collegePercentage ?>%</div>
                            <div class="text-gray-700 fw-bold">Melanjutkan Kuliah</div>
                            <div class="text-muted fs-8">Alumni melanjutkan pendidikan</div>
                        </div>
                    </div>
                </div>

                <!-- Wirausaha -->
                <div class="col-md-4">
                    <div class="card card-stretch h-100 border-0 bg-light-info bg-opacity-10 shadow-sm">
                        <div class="card-body text-center">
                            <?php
                            $entrepreneurCount = 0;
                            foreach ($statusAlumniData as $item) {
                                if (stripos($item['label'], 'wirausaha') !== false || stripos($item['label'], 'usaha') !== false) {
                                    $entrepreneurCount = $item['value'];
                                    break;
                                }
                            }
                            $entrepreneurPercentage = $totalCount > 0 ? round(($entrepreneurCount / $totalCount) * 100, 1) : 0;
                            ?>
                            <div class="text-info fs-1 fw-bolder mb-2"><?= $entrepreneurPercentage ?>%</div>
                            <div class="text-gray-700 fw-bold">Wirausaha</div>
                            <div class="text-muted fs-8">Alumni berwirausaha</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Insight Tambahan-->

</div>
<!--end::Container-->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if (isset($tracerChartLabels) && isset($tracerChartData) && count($tracerChartLabels) > 0): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Line Chart - Tracer Study (6 months)
            const tracerChartEl = document.getElementById('tracerChart');
            if (tracerChartEl && typeof window.ApexCharts !== 'undefined') {
                new window.ApexCharts(tracerChartEl, {
                    series: [{
                        name: 'Jumlah Alumni',
                        data: <?= json_encode($tracerChartData) ?>
                    }],
                    chart: {
                        type: 'area',
                        height: 350,
                        fontFamily: 'Segoe UI, Tahoma, Geneva, Verdana, sans-serif',
                        toolbar: {
                            show: false
                        },
                        background: 'transparent'
                    },
                    colors: ['#703eff'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0.1,
                            stops: [0, 90, 100]
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    grid: {
                        borderColor: '#e5e7eb',
                        strokeDashArray: 4
                    },
                    xaxis: {
                        categories: <?= json_encode($tracerChartLabels) ?>,
                        labels: {
                            style: {
                                colors: '#6b7280',
                                fontSize: '12px'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#6b7280',
                                fontSize: '12px'
                            }
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        style: {
                            fontSize: '12px'
                        },
                        x: {
                            format: 'MMM YYYY'
                        }
                    }
                }).render();
            }

            // Donut Chart - Status Alumni
            const alumniStatusEl = document.getElementById('statusAlumniChart');
            if (alumniStatusEl && typeof window.ApexCharts !== 'undefined') {
                const statusData = <?= json_encode($statusAlumniData) ?>;
                const labels = statusData.map(item => item.label);
                const values = statusData.map(item => item.value);
                const total = values.reduce((a, b) => a + b, 0);

                new window.ApexCharts(alumniStatusEl, {
                    series: values,
                    chart: {
                        type: 'donut',
                        height: 350,
                        fontFamily: 'Segoe UI, Tahoma, Geneva, Verdana, sans-serif',
                        toolbar: {
                            show: false
                        }
                    },
                    labels: labels,
                    colors: ['#1ecab8', '#703eff', '#f64e60', '#ffb800', '#6c757d'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        color: '#374151',
                                        fontSize: '16px',
                                        fontWeight: 600
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            if (total > 0) {
                                return Math.round(val) + '%';
                            }
                            return '0%';
                        }
                    },
                    legend: {
                        position: 'bottom',
                        fontSize: '12px',
                        labels: {
                            colors: '#374151'
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return val + ' alumni';
                            }
                        }
                    }
                }).render();
            }
        });
    </script>
<?php endif; ?>
<?= $this->endSection() ?>