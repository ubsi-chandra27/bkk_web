<?= $this->extend('admin/layout/app') ?>

<?= $this->section('content') ?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl py-6">

    <!--begin::Hero Banner (Gradient)-->
    <div class="row mb-6">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body position-relative p-6">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between">
                        <div class="mb-4 mb-lg-0">
                            <h1 class="text-gray-900 fw-bold mb-2 display-6">
                                Selamat datang, <span class="text-primary"><?= esc($namaPerusahaan) ?></span>
                            </h1>
                            <p class="text-gray-600 fs-5 mb-0">Pantau lowongan dan kandidat Anda dengan mudah</p>
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
                                    <p class="text-muted fw-bold mb-1">Tanggal</p>
                                    <p class="text-dark fw-bold fs-3 mb-0"><?= date('d F Y') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--begin::Alert Banner (New Applications)-->
    <?php if ($totalBaru > 0): ?>
        <div class="row mb-5">
            <div class="col-12">
                <div class="alert alert-dismissible bg-light-primary border border-primary border-start-4 mb-6" role="alert" id="alertBaru">
                    <div class="d-flex align-items-center">
                        <span class="svg-icon svg-icon-2hx me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M21 7L9 19L3 13L2 14L9 21L22 8L21 7Z" fill="currentColor" />
                            </svg>
                        </span>
                        <div class="flex-grow-1">
                            <h4 class="text-gray-900 fw-bold mb-1">Ada <?= $totalBaru ?> lamaran baru menunggu review</h4>
                            <p class="text-gray-700 mb-0">Segera tinjau dan proses kandidat terbaik Anda.</p>
                        </div>
                        <a href="<?= base_url('admin/data-lamaran') ?>" class="btn btn-primary">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 9L14 9L14 8C14 6.89543 14.8954 6 16 6L17 6C18.1046 6 19 6.89543 19 8L19 9L20 9C20.5523 9 21 9.44772 21 10L21 11C21 11.5523 20.5523 12 20 12L19 12L19 20C19 20.5523 18.5523 21 18 21L17 21C16.4477 21 16 20.5523 16 20L16 12L15 12L8 20L8 12L7 12C6.44772 12 6 11.5523 6 11L6 10C6 9.44772 6.44772 9 7 9L8 9L5 9ZM17 8L16 8C15.4477 8 15 8.44772 15 9L15 9L9 9L9 8C9 7.44772 9.44772 7 10 7L11 7C11.5523 7 12 7.44772 12 8L12 9L17 9L17 8Z" fill="currentColor" />
                                </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!--begin::Row Statistics Cards-->
    <div class="row g-4 mb-6">
        <div class="col-12">
            <div class="row g-4">
                <!--begin::Col-->
                <div class="col-xl-3 col-lg-6">
                    <div class="card stat-card-custom card-stretch h-100 border-0 shadow-sm">
                        <div class="top-accent" style="background:#378ADD;"></div>
                        <div class="card-body pt-7">
                            <div class="icon-box mb-4" style="background:#E6F1FB;">
                                <i class="fa-solid fa-briefcase" style="color:#0C447C;font-size:18px;"></i>
                            </div>
                            <div class="text-muted fw-semibold fs-7 text-uppercase ls-1 mb-1">Total Lowongan Aktif</div>
                            <div class="text-gray-900 fs-2hx fw-bolder mb-2"><?= $totalLowongan ?></div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="text-muted fs-8">Lowongan berjalan</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-xl-3 col-lg-6">
                    <div class="card stat-card-custom card-stretch h-100 border-0 shadow-sm">
                        <div class="top-accent" style="background:#7F77DD;"></div>
                        <div class="card-body pt-7">
                            <div class="icon-box mb-4" style="background:#EEEDFE;">
                                <i class="fa-solid fa-file-lines" style="color:#3C3489;font-size:18px;"></i>
                            </div>
                            <div class="text-muted fw-semibold fs-7 text-uppercase ls-1 mb-1">Total Lamaran</div>
                            <div class="text-gray-900 fs-2hx fw-bolder mb-2"><?= $totalLamaran ?></div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="text-muted fs-8">Kandidat melamar</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-xl-3 col-lg-6">
                    <div class="card stat-card-custom card-stretch h-100 border-0 shadow-sm">
                        <div class="top-accent" style="background:#EF9F27;"></div>
                        <div class="card-body pt-7">
                            <div class="icon-box mb-4" style="background:#FAEEDA;">
                                <i class="fa-solid fa-clock" style="color:#633806;font-size:18px;"></i>
                            </div>
                            <div class="text-muted fw-semibold fs-7 text-uppercase ls-1 mb-1">Kandidat Diproses</div>
                            <div class="text-gray-900 fs-2hx fw-bolder mb-2"><?= $totalDiproses ?></div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="text-muted fs-8">Sedang dinilai</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-xl-3 col-lg-6">
                    <div class="card stat-card-custom card-stretch h-100 border-0 shadow-sm">
                        <div class="top-accent" style="background:#1D9E75;"></div>
                        <div class="card-body pt-7">
                            <div class="icon-box mb-4" style="background:#E1F5EE;">
                                <i class="fa-solid fa-circle-check" style="color:#085041;font-size:18px;"></i>
                            </div>
                            <div class="text-muted fw-semibold fs-7 text-uppercase ls-1 mb-1">Kandidat Diterima</div>
                            <div class="text-gray-900 fs-2hx fw-bolder mb-2"><?= $totalDiterima ?></div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="text-muted fs-8">Berhasil diterima</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::inner row-->
            </div>
            <!--end::wrapper-->
        </div>
        <!--end::Row Statistics Cards-->
        <!--begin::Row Chart & Recent Applications-->

        <div class="row g-5 mb-6">
            <!--begin::Col Chart-->
            <div class="col-xl-8">
                <div class="card card-stretch h-100 border-0 shadow-sm">
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title fw-bold text-gray-900 fs-4">Grafik Lamaran (7 Hari Terakhir)</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart_lamaran" data-chart='<?= json_encode($chartData) ?>' style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>
            <!--end::Col Chart-->

            <!--begin::Col Recent Applications-->
            <div class="col-xl-4">
                <div class="card card-stretch h-100 border-0 shadow-sm">
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title fw-bold text-gray-900 fs-4">Lamaran Terbaru</h3>
                    </div>
                    <div class="card-body pt-2">
                        <?php if (empty($lamaranTerbaru)): ?>
                            <div class="text-center py-8">
                                <span class="svg-icon svg-icon-5hx text-gray-300 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M19 3H5C4 3 3 4 3 5V19C3 20 4 21 5 21H19C20 21 21 20 21 19V5C21 4 20 3 19 3ZM19 19H5V5H19V19ZM11 7H13V13H11V7ZM11 15H13V17H11V15Z" fill="currentColor" fill-opacity="0.3" />
                                        <path d="M7 7H9V9H7V7ZM7 11H9V13H7V11ZM13 7H15V9H13V7ZM13 11H15V13H13V11Z" fill="currentColor" />
                                        <path d="M17 7H19V9H17V7ZM17 11H19V13H17V11Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <p class="text-gray-500">Belum ada lamaran masuk</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($lamaranTerbaru as $lamaran):
                                $initials = substr(strip_tags($lamaran['nama_lengkap'] ?? 'U'), 0, 2);
                                $statusConfig = match (($lamaran['status'] ?? '')) {
                                    'menunggu_diverifikasi' => ['label' => 'Baru', 'class' => 'bg-light-warning text-warning'],
                                    'diproses' => ['label' => 'Diproses', 'class' => 'bg-light-info text-info'],
                                    'interview' => ['label' => 'Interview', 'class' => 'bg-light-primary'],
                                    'diterima' => ['label' => 'Diterima', 'class' => 'bg-light-success text-success'],
                                    'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-light-danger text-danger'],
                                    default => ['label' => ($lamaran['status'] ?? 'Baru'), 'class' => 'bg-light-secondary text-secondary']
                                };
                            ?>
                                <!--begin::Item-->
                                <div class="d-flex flex-column mb-4 pb-4 border-bottom border-gray-200 last:border-0 last:pb-0">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="symbol symbol-45px symbol-circle me-3">
                                            <span class="symbol-label bg-gray-200 text-gray-800 fs-6 fw-bold">
                                                <?= strtoupper($initials) ?>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="text-gray-900 fw-bold mb-0"><?= esc($lamaran['nama_lengkap']) ?></h6>
                                            <span class="text-gray-500 fs-8"><?= esc($lamaran['posisi']) ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="badge <?= $statusConfig['class'] ?> fs-8 fw-bold px-3 py-2">
                                            <?= $statusConfig['label'] ?>
                                        </span>
                                        <small class="text-gray-400"><?= date('d M H:i', time() - (rand(1, 5) * 3600)) ?></small>
                                    </div>
                                </div>
                                <!--end::Item-->
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!--end::Col Recent Applications-->
        </div>
        <!--end::inner row-->


        <!--begin::Row Active Jobs-->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card card-stretch border-0 shadow-sm">
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title fw-bold text-gray-900 fs-4">Lowongan Aktif</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($activeJobs)): ?>
                            <!-- Empty State -->
                            <div class="text-center py-12">
                                <span class="svg-icon svg-icon-5hx text-gray-300 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V8L14 2Z" fill="currentColor" fill-opacity="0.3" />
                                        <path d="M15 4H18C18.6 4 19 4.4 19 5C19 5.6 18.6 6 18 6H15V4Z" fill="currentColor" />
                                        <path d="M8 4H11C11.6 4 12 4.4 12 5C12 5.6 11.6 6 11 6H8V4Z" fill="currentColor" />
                                        <path opacity="0.3" d="M10 8V11C10 11.6 9.6 12 9 12C8.4 12 8 11.6 8 11V8H10ZM14 8V11C14 11.6 13.6 12 13 12C12.4 12 12 11.6 12 11V8H14ZM16 8V11C16 11.6 15.6 12 15 12C14.4 12 14 11.6 14 11V8H16Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <h5 class="text-gray-600 fw-bold mb-2">Belum ada lowongan aktif</h5>
                                <p class="text-gray-500 mb-4">Mulai posting lowongan untuk menarik kandidat</p>
                                <a href="<?= base_url('admin/data-lowongan/create') ?>" class="btn btn-light-primary">
                                    <span class="svg-icon svg-icon-2 me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 5V11L7 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3H17V5C17 6.1 16.1 7 15 7C13.9 7 13 6.1 13 5V3H11V5C11 6.1 10.1 7 9 7C7.9 7 7 6.1 7 5V3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H17V19C17 18.9 16.1 18.9 15 18.9C13.9 18.9 13 18 13 17.1V18.9H11V17.1C11 16.2 10.1 15.3 9 15.3C7.9 15.3 7 16.2 7 17.1V19H5C3.9 19 3 20.1 3 21H21C20.9 21 19.9 20.9 19 19.9V7.1C19 5.8 18.1 4.7 16.9 4.7C15.7 4.7 15 5.4 15 6.6V8H9V6.6C9 5.4 8.3 4.7 7.1 4.7C5.9 4.7 5 5.8 5 7.1V19C5 20.2 5.8 21 7 21H19C20.2 21 21 20.2 21 19V5C21 3.8 20.2 3 19 3H7L12 5L14 3H19C18.9 3 17.9 3 17 3H7L12 5L15 3C15 1.9 15.9 1 17 1C18.1 1 19 1.9 19 3H19" fill="currentColor" />
                                        </svg>
                                    </span>
                                    Buat Lowongan Baru
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle gy-6">
                                    <thead class="text-muted fw-bold fs-7 text-uppercase bg-light-primary bg-opacity-50">
                                        <tr>
                                            <th class="w-25">Posisi</th>
                                            <th class="w-15">Jenis</th>
                                            <th class="w-15">Lokasi</th>
                                            <th class="w-10 text-center">Pelamar</th>
                                            <th class="w-20">Batas Lamaran</th>
                                            <th class="w-15 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-7">
                                        <?php foreach ($activeJobs as $job): ?>
                                            <tr class="border-bottom border-gray-200">
                                                <td>
                                                    <a href="<?= base_url('admin/data-lowongan/show/' . $job['id']) ?>" class="text-gray-900 text-hover-primary fw-bold">
                                                        <?= esc($job['posisi']) ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light-primary text-primary fw-bold px-3 py-2">
                                                        <?= esc($job['jenis_pekerjaan']) ?>
                                                    </span>
                                                </td>
                                                <td class="text-gray-600">
                                                    <span class="svg-icon svg-icon-5 svg-icon-success me-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 5.02944 7.02944 1 12 1C16.9706 1 21 5.02944 21 10Z" stroke="currentColor" stroke-width="2" />
                                                            <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10" stroke="currentColor" stroke-opacity="0.3" stroke-width="2" />
                                                            <circle cx="12" cy="10" r="3" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <?= esc($job['lokasi_kerja']) ?>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-light-primary fw-bold px-4 py-2 fs-8">
                                                        <?= $job['jumlah_pelamar'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($job['batas_lamaran']): ?>
                                                        <?php
                                                        $remaining = strtotime($job['batas_lamaran']) - time();
                                                        $daysLeft = floor($remaining / (60 * 60 * 24));
                                                        $isUrgent = $daysLeft <= 7;
                                                        ?>
                                                        <span class="text-gray-800 fw-bold <?= $isUrgent ? 'text-danger' : '' ?>">
                                                            <?= date('d M Y', strtotime($job['batas_lamaran'])) ?>
                                                        </span>
                                                        <?php if ($isUrgent && $daysLeft >= 0): ?>
                                                            <span class="badge badge-light-danger ms-2"><?= $daysLeft ?> hari</span>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span class="text-gray-400">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <a href="<?= base_url('admin/data-lowongan/show/' . $job['id']) ?>"
                                                        class="btn btn-sm btn-light-primary btn-active-light-primary fw-bold">
                                                        Lihat Detail
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
        </div>

        <!--begin::Row Profile Completion-->
        <div class="row g-5">
            <div class="col-12">
                <?php if (!$profileComplete): ?>
                    <div class="alert alert-warning border border-warning border-start-4 d-flex align-items-center py-4" role="alert">
                        <span class="svg-icon svg-icon-2hx me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12 9V13M12 17H12.01M5.07 19H18.93C20.4 19 21.63 17.37 21.36 15.86L19.51 3.86C19.19 2.25 17.59 1.5 16 2.02L7.49 6.17C5.88 6.72 5.07 8.44 5.07 10.81L5.07 19Z" stroke="warning" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <div class="flex-grow-1">
                            <h4 class="text-warning fw-bold mb-1">Lengkapi profil perusahaan Anda</h4>
                            <p class="text-gray-700 mb-0">Profil yang lengkap akan meningkatkan kepercayaan kandidat. Lengkapi informasi seperti alamat, logo, website, dan nomor telepon.</p>
                        </div>
                        <a href="<?= base_url('admindudi/profil-perusahaan') ?>"
                            class="btn btn-warning me-2">
                            Lengkapi Sekarang
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php else: ?>
                    <div class="alert alert-success border border-success border-start-4 d-flex align-items-center py-4" role="alert">
                        <span class="svg-icon svg-icon-2hx me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="success" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <div class="flex-grow-1">
                            <h4 class="text-success fw-bold mb-1">Profil perusahaan sudah lengkap!</h4>
                            <p class="text-gray-700 mb-0">Profil Anda menarik dan siap menarik kandidat terbaik.</p>
                        </div>
                        <a href="<?= base_url('admindudi/profil-perusahaan') ?>"
                            class="btn btn-success me-2">
                            Lihat Profil
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <!--end::Container-->
    <?= $this->endSection() ?>

    <?= $this->section('styles') ?>
    <style>
        /* Hero gradient */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Card hover effects */
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Chart styling */
        #chart_lamaran {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .apexcharts-tooltip {
            background: #fff !important;
            border: 1px solid #e0e0e0 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            border-radius: 8px !important;
        }

        .apexcharts-gridline,
        .apexcharts-xaxis line,
        .apexcharts-yaxis line {
            stroke: #f0f0f0 !important;
        }

        .apexcharts-text {
            fill: #6b7280 !important;
        }

        .apexcharts-title {
            font-weight: 600 !important;
            color: #111827 !important;
        }

        /* Empty state illustration */
        .empty-state-illustration {
            width: 120px;
            height: 120px;
            object-fit: contain;
        }
    </style>
    <?= $this->endSection() ?>

    <?= $this->section('scripts') ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize ApexCharts for 7-day applications
            const chartContainer = document.getElementById('chart_lamaran');
            if (chartContainer && typeof window.ApexCharts !== 'undefined') {
                const chartData = JSON.parse(chartContainer.getAttribute('data-chart') || '[]');

                // Generate last 7 day labels
                const labels = [];
                for (let i = 6; i >= 0; i--) {
                    const date = new Date();
                    date.setDate(date.getDate() - i);
                    labels.push(date.toLocaleDateString('id-ID', {
                        weekday: 'short',
                        day: 'numeric'
                    }));
                }

                const options = {
                    series: [{
                        name: 'Jumlah Lamaran',
                        data: chartData
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
                            opacityFrom: 0.7,
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
                        categories: labels,
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
                            format: 'dd MMM'
                        }
                    }
                };

                new window.ApexCharts(chartContainer, options).render();
            }

            // Dismissible alert
            const alertClose = document.querySelector('#alertBaru .btn-close');
            if (alertClose) {
                alertClose.addEventListener('click', function() {
                    const alert = document.getElementById('alertBaru');
                    if (alert) {
                        alert.remove();
                    }
                });
            }

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
    <?= $this->endSection() ?>
