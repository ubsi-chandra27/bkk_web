<?= $this->extend('admin/layout/app') ?>
<?= $this->section('content') ?>
<?php
$statusPendaftaran = strtolower((string) ($pelamar['status_pendaftaran'] ?? 'menunggu_aktivasi'));
$statusPendaftaranLabel = 'Menunggu Aktivasi';
$statusPendaftaranBadge = 'warning';
$berkasLamaran = $berkasLamaran ?? [];
$selectedLamaran = $selectedLamaran ?? null;
$selectedTab = $selectedTab ?? '';

if ($statusPendaftaran === 'terdaftar') {
    $statusPendaftaranLabel = 'Terdaftar';
    $statusPendaftaranBadge = 'info';
} elseif ($statusPendaftaran === 'aktif') {
    $statusPendaftaranLabel = 'Aktif';
    $statusPendaftaranBadge = 'success';
}
?>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success mb-4"><?= session()->getFlashdata('success') ?></div>
        <?php endif ?>

        <!-- Navbar Profil -->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <!-- Foto -->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <?php $foto = $pelamar['foto'] ?? null; ?>
                            <img src="<?= $foto ? base_url('uploads/foto/' . $foto) : base_url('assets/media/avatars/blank.png') ?>" alt="foto" />
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-<?= ($user['is_active'] ?? 0) ? 'success' : 'danger' ?> rounded-circle border border-4 border-white h-20px w-20px"></div>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-gray-900 fs-2 fw-bolder me-3"><?= esc($user['nama']) ?></span>
                                    <span class="badge badge-light-<?= ($user['is_active'] ?? 0) ? 'success' : 'danger' ?>">
                                        <?= ($user['is_active'] ?? 0) ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </div>
                                <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                        <span class="svg-icon svg-icon-4 me-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="black" />
                                                <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="black" />
                                            </svg>
                                        </span>
                                        <?= esc($user['email']) ?>
                                    </span>
                                    <?php if (!empty($pelamar['telepon'] ?? $user['telepon'] ?? null)): ?>
                                        <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                            <span class="svg-icon svg-icon-4 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="black" />
                                                </svg>
                                            </span>
                                            <?= esc($pelamar['telepon'] ?? '-') ?>
                                        </span>
                                    <?php endif ?>
                                    <?php if (!empty($pelamar['alamat'])): ?>
                                        <span class="d-flex align-items-center text-gray-400 mb-2">
                                            <span class="svg-icon svg-icon-4 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="black" />
                                                    <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="black" />
                                                </svg>
                                            </span>
                                            <?= esc($pelamar['alamat']) ?>
                                        </span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="d-flex my-4">
                                <a href="<?= site_url('admin/data-pelamar/profil/' . $user['id'] . '/edit') ?>" class="btn btn-sm btn-primary">
                                    Edit Profil
                                </a>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="d-flex flex-wrap flex-stack">
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <div class="d-flex flex-wrap">
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="fs-6 fw-bold text-gray-700">Role</div>
                                        <div class="fw-bold fs-6 text-gray-400"><?= esc($user['id_role'] == 4 ? 'Pelamar Alumni' : 'Pelamar Umum') ?></div>
                                    </div>
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="fs-6 fw-bold text-gray-700">Bergabung</div>
                                        <div class="fw-bold fs-6 text-gray-400"><?= date('d M Y', strtotime($user['created_at'])) ?></div>
                                    </div>
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="fs-6 fw-bold text-gray-700">Status Pendaftaran</div>
                                        <div class="fw-bold fs-6 text-gray-400">
                                            <span class="badge badge-light-<?= $statusPendaftaranBadge ?>"><?= esc($statusPendaftaranLabel) ?></span>
                                        </div>
                                    </div>
                                    <?php if (!empty($pelamar['account_id'])): ?>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="fs-6 fw-bold text-gray-700">Account ID</div>
                                            <div class="fw-bold fs-6 text-gray-400"><?= esc($pelamar['account_id']) ?></div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Nav -->
                <div class="d-flex overflow-auto h-55px">
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6 active"
                                data-bs-toggle="tab" href="#tab_data_diri">
                                <i class="bi bi-person me-2"></i>Data Diri
                            </a>
                        </li>
                        <?php if ($user['id_role'] == 4): // Alumni 
                        ?>
                            <li class="nav-item">
                                <a class="nav-link text-active-primary me-6"
                                    data-bs-toggle="tab" href="#tab_tracer">
                                    <i class="bi bi-graph-up me-2"></i>Tracer Alumni
                                </a>
                            </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6"
                                data-bs-toggle="tab" href="#tab_berkas">
                                <i class="bi bi-file-earmark me-2"></i>Berkas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6"
                                data-bs-toggle="tab" href="#tab_lamaran">
                                <i class="bi bi-briefcase me-2"></i>Riwayat Lamaran
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">

            <!-- Tab Data Diri -->
            <div class="tab-pane fade show active" id="tab_data_diri">
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Data Diri</h3>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="row">
                            <!-- Nama -->
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-primary rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-person fs-4 text-primary"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">Nama</div>
                                        <div class="fw-bolder fs-6"><?= esc($user['nama']) ?></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-info rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-envelope fs-4 text-info"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">Email</div>
                                        <div class="fw-bolder fs-6"><?= esc($user['email']) ?></div>
                                    </div>
                                </div>
                            </div>
                            <!-- NIK -->
                            <?php if (!empty($pelamar['nomer_nik'])): ?>
                                <div class="col-md-6 mb-6">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40px me-4 bg-light-dark rounded">
                                            <span class="symbol-label">
                                                <i class="bi bi-card-text fs-4 text-dark"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-7">NIK</div>
                                            <div class="fw-bolder fs-6"><?= esc($pelamar['nomer_nik']) ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <!-- No Telepon -->
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-success rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-telephone fs-4 text-success"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">No. Telepon</div>
                                        <div class="fw-bolder fs-6"><?= esc($pelamar['telepon'] ?? '-') ?></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Alamat -->
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-warning rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-geo-alt fs-4 text-warning"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">Alamat</div>
                                        <div class="fw-bolder fs-6"><?= esc($pelamar['alamat'] ?? '-') ?></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tanggal Lahir -->
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-warning rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-patch-check fs-4 text-warning"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">Status Pendaftaran</div>
                                        <div class="fw-bolder fs-6">
                                            <span class="badge badge-light-<?= $statusPendaftaranBadge ?>"><?= esc($statusPendaftaranLabel) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-danger rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-house fs-4 text-success"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">Tempat Lahir</div>
                                        <div class="fw-bolder fs-6"><?= esc($pelamar['tempat_lahir'] ?? '-') ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-info rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-calendar-check fs-4 text-info"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">Terdaftar Pada</div>
                                        <div class="fw-bolder fs-6"><?= !empty($pelamar['terdaftar_pada']) ? date('d-m-Y H:i', strtotime($pelamar['terdaftar_pada'])) : '-' ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-danger rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-calendar fs-4 text-danger"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">Tanggal Lahir</div>
                                        <div class="fw-bolder fs-6"><?= !empty($pelamar['tanggal_lahir']) ? date('d-m-Y', strtotime($pelamar['tanggal_lahir'])) : '-' ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-success rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-person-check fs-4 text-success"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">Diaktivasi Pada</div>
                                        <div class="fw-bolder fs-6"><?= !empty($pelamar['diaktivasi_pada']) ? date('d-m-Y H:i', strtotime($pelamar['diaktivasi_pada'])) : '-' ?></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Jenis Kelamin -->
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-primary rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-gender-ambiguous fs-4 text-primary"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">Jenis Kelamin</div>
                                        <div class="fw-bolder fs-6">
                                            <?php
                                            $jk = $pelamar['jenis_kelamin'] ?? '-';
                                            echo $jk === 'L' ? 'Laki-laki' : ($jk === 'P' ? 'Perempuan' : '-');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-4 bg-light-success rounded">
                                        <span class="symbol-label">
                                            <i class="bi bi-person-badge fs-4 text-success"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-7">Diaktivasi Oleh</div>
                                        <div class="fw-bolder fs-6"><?= esc($aktivator['nama'] ?? (!empty($pelamar['diaktivasi_oleh']) ? 'User #' . $pelamar['diaktivasi_oleh'] : '-')) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Tracer Alumni -->
            <div class="tab-pane fade" id="tab_tracer">
                <?php if ($user['id_role'] == 4): // Alumni 
                ?>
                    <div class="row g-6">

                        <!-- Kolom Kiri: Data Alumni -->
                        <div class="col-lg-4">
                            <div class="card card-flush shadow-sm">
                                <div class="card-header border-bottom">
                                    <div class="card-title">
                                        <h3 class="fw-bolder m-0">Data Alumni</h3>
                                    </div>
                                </div>
                                <div class="card-body p-9">
                                    <?php if (!empty($alumni)): ?>
                                        <?php
                                        $alumniFields = [
                                            ['label' => 'Kompetensi Keahlian', 'value' => ($alumni['kompetensi_keahlian'] ?? '-') . ' (' . ($alumni['akronim'] ?? '') . ')'],
                                            ['label' => 'Angkatan',            'value' => $alumni['tahun'] ?? '-'],
                                            ['label' => 'NIS',                 'value' => $alumni['nis'] ?? '-'],
                                            ['label' => 'NISN',                'value' => $alumni['nisn'] ?? '-'],
                                            ['label' => 'No. Ijazah',          'value' => $alumni['no_ijazah'] ?? '-'],
                                        ];
                                        foreach ($alumniFields as $af): ?>
                                            <div class="mb-6">
                                                <div class="text-muted fs-7 mb-1"><?= $af['label'] ?></div>
                                                <div class="fw-bolder fs-6"><?= esc($af['value']) ?></div>
                                            </div>
                                        <?php endforeach ?>

                                        <div class="separator separator-dashed my-5"></div>

                                        <?php if (!empty($alumni['is_verifikasi'])): ?>
                                            <span class="badge badge-light-success px-4 py-2">
                                                <i class="bi bi-patch-check-fill me-1 text-success"></i>Terverifikasi
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-light-warning px-4 py-2">
                                                <i class="bi bi-clock me-1 text-warning"></i>Menunggu Verifikasi
                                            </span>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <div class="text-center py-10">
                                            <i class="bi bi-person-badge fs-3x text-gray-400 mb-3 d-block"></i>
                                            <div class="text-muted fs-6">Data alumni belum tersedia</div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Data Tracer -->
                        <div class="col-lg-8">
                            <div class="card card-flush shadow-sm">
                                <div class="card-header border-bottom">
                                    <div class="card-title">
                                        <h3 class="fw-bolder m-0">Data Tracer Study</h3>
                                    </div>
                                </div>
                                <div class="card-body p-9">
                                    <?php if (!empty($tracer)): ?>
                                        <div class="row g-6">

                                            <!-- Status -->
                                            <div class="col-md-6">
                                                <div class="mb-6">
                                                    <div class="text-muted fs-7 mb-1">Status Aktivitas</div>
                                                    <div class="fw-bolder fs-6"><?= esc($tracer['nama_aktivitas'] ?? '-') ?></div>
                                                </div>
                                                <div class="mb-6">
                                                    <div class="text-muted fs-7 mb-2">Status Verifikasi</div>
                                                    <?php
                                                    $statusColor = match ($tracer['status'] ?? '') {
                                                        'terkirim'      => 'primary',
                                                        'terverifikasi' => 'info',
                                                        'disetujui'     => 'success',
                                                        default         => 'warning'
                                                    };
                                                    ?>
                                                    <span class="badge badge-light-<?= $statusColor ?> px-4 py-2">
                                                        <?= ucfirst(str_replace('_', ' ', $tracer['status'] ?? '-')) ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Data Pekerjaan -->
                                            <?php if (!empty($tracer['nama_dudi'])): ?>
                                                <div class="col-md-6">
                                                    <div class="mb-6">
                                                        <div class="text-muted fs-7 mb-1">Nama Perusahaan / DU-DI</div>
                                                        <div class="fw-bolder fs-6"><?= esc($tracer['nama_dudi']) ?></div>
                                                    </div>
                                                    <div class="mb-6">
                                                        <div class="text-muted fs-7 mb-1">Posisi / Jabatan</div>
                                                        <div class="fw-bolder fs-6"><?= esc($tracer['posisi_kerja'] ?? '-') ?></div>
                                                    </div>
                                                    <div class="mb-6">
                                                        <div class="text-muted fs-7 mb-1">Tahun Mulai Kerja</div>
                                                        <div class="fw-bolder fs-6"><?= esc($tracer['tahun_mulai_kerja'] ?? '-') ?></div>
                                                    </div>
                                                    <?php if (!empty($tracer['penghasilan_range'])): ?>
                                                        <div class="mb-6">
                                                            <div class="text-muted fs-7 mb-1">Penghasilan</div>
                                                            <div class="fw-bolder fs-6"><?= esc($tracer['penghasilan_range']) ?></div>
                                                        </div>
                                                    <?php endif ?>
                                                    <?php if (!empty($tracer['bidang_dudi'])): ?>
                                                        <div class="mb-6">
                                                            <div class="text-muted fs-7 mb-1">Bidang Usaha DU/DI</div>
                                                            <div class="fw-bolder fs-6"><?= esc($tracer['bidang_dudi']) ?></div>
                                                        </div>
                                                    <?php endif ?>
                                                    <?php if (isset($tracer['is_relevan_jurusan'])): ?>
                                                        <div class="mb-6">
                                                            <div class="text-muted fs-7 mb-1">Relevan dengan Jurusan</div>
                                                            <span class="badge badge-light-<?= $tracer['is_relevan_jurusan'] ? 'success' : 'warning' ?> px-3 py-2">
                                                                <?= $tracer['is_relevan_jurusan'] ? 'Ya' : 'Tidak' ?>
                                                            </span>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                            <?php endif ?>

                                            <!-- Data Kuliah -->
                                            <?php if (!empty($tracer['universitas'])): ?>
                                                <div class="col-md-6">
                                                    <div class="mb-6">
                                                        <div class="text-muted fs-7 mb-1">Universitas</div>
                                                        <div class="fw-bolder fs-6"><?= esc($tracer['universitas']) ?></div>
                                                    </div>
                                                    <div class="mb-6">
                                                        <div class="text-muted fs-7 mb-1">Program Studi</div>
                                                        <div class="fw-bolder fs-6"><?= esc($tracer['program_studi'] ?? '-') ?></div>
                                                    </div>
                                                    <?php if (!empty($tracer['status_kuliah'])): ?>
                                                        <div class="mb-6">
                                                            <div class="text-muted fs-7 mb-1">Status Kuliah</div>
                                                            <div class="fw-bolder fs-6"><?= esc($tracer['status_kuliah']) ?></div>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                            <?php endif ?>

                                            <!-- Data Usaha -->
                                            <?php if (!empty($tracer['nama_usaha'])): ?>
                                                <div class="col-md-6">
                                                    <div class="mb-6">
                                                        <div class="text-muted fs-7 mb-1">Nama Usaha</div>
                                                        <div class="fw-bolder fs-6"><?= esc($tracer['nama_usaha']) ?></div>
                                                    </div>
                                                    <div class="mb-6">
                                                        <div class="text-muted fs-7 mb-1">Bidang Usaha</div>
                                                        <div class="fw-bolder fs-6"><?= esc($tracer['bidang_usaha'] ?? '-') ?></div>
                                                    </div>
                                                    <?php if (!empty($tracer['penghasilan_usaha'])): ?>
                                                        <div class="mb-6">
                                                            <div class="text-muted fs-7 mb-1">Penghasilan Usaha</div>
                                                            <div class="fw-bolder fs-6"><?= esc($tracer['penghasilan_usaha']) ?></div>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                            <?php endif ?>

                                            <!-- Rencana Lanjut -->
                                            <?php if (!empty($tracer['rencana_universitas'])): ?>
                                                <div class="col-md-6">
                                                    <div class="mb-6">
                                                        <div class="text-muted fs-7 mb-1">Rencana Universitas</div>
                                                        <div class="fw-bolder fs-6"><?= esc($tracer['rencana_universitas']) ?></div>
                                                    </div>
                                                    <?php if (!empty($tracer['rencana_prodi'])): ?>
                                                        <div class="mb-6">
                                                            <div class="text-muted fs-7 mb-1">Rencana Program Studi</div>
                                                            <div class="fw-bolder fs-6"><?= esc($tracer['rencana_prodi']) ?></div>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                            <?php endif ?>

                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-15">
                                            <i class="bi bi-graph-up fs-3x text-gray-400 mb-5 d-block"></i>
                                            <div class="text-muted fs-5 mb-5">Belum ada data tracer study</div>
                                            <div class="text-muted fs-7">Data tracer alumni akan muncul setelah pelamar mengisi form tracer study</div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-body text-center py-15">
                            <i class="bi bi-person fs-3x text-muted mb-4 d-block"></i>
                            <div class="text-muted fs-5">Fitur Tracer Alumni hanya untuk Alumni</div>
                        </div>
                    </div>
                <?php endif ?>
            </div>

            <!-- Tab Berkas -->
            <div class="tab-pane fade" id="tab_berkas">
                <div class="card shadow-sm card-flush">
                    <div class="card-header border-bottom">
                        <div class="card-title">
                            <h3 class="fw-bolder m-0">Berkas Dokumen</h3>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <?php if ($selectedLamaran): ?>
                            <div class="card card-bordered mb-8">
                                <div class="card-body p-6">
                                    <div class="d-flex align-items-center justify-content-between gap-4 flex-wrap mb-5">
                                        <div>
                                            <div class="fw-bolder fs-5 text-gray-900 mb-1">Berkas Lamaran Terkait</div>
                                            <div class="text-muted fs-7">
                                                Lamaran untuk <?= esc($selectedLamaran['posisi'] ?? '-') ?> di <?= esc($selectedLamaran['nama_perusahaan'] ?? '-') ?>
                                            </div>
                                        </div>
                                        <span class="badge badge-light-info">ID Lamaran #<?= esc($selectedLamaran['id']) ?></span>
                                    </div>

                                    <?php if (!empty($berkasLamaran)): ?>
                                        <div class="row g-4">
                                            <?php foreach ($berkasLamaran as $item): ?>
                                                <div class="col-md-6">
                                                    <div class="border border-gray-300 border-dashed rounded p-5 h-100">
                                                        <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                                                            <div>
                                                                <div class="fw-bold fs-6"><?= esc($item['nama_berkas'] ?? 'Berkas Lamaran') ?></div>
                                                                <div class="text-muted fs-7"><?= esc($item['file_name'] ?? '-') ?></div>
                                                            </div>
                                                            <span class="badge badge-light-success">Terupload</span>
                                                        </div>
                                                        <a href="<?= base_url($item['file_path']) ?>" target="_blank" class="btn btn-sm btn-light-primary">
                                                            <i class="bi bi-eye me-1"></i>Lihat Berkas
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning mb-0">
                                            Berkas lamaran untuk lamaran ini belum tersedia.
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="row g-6">
                            <?php
                            $iconMap = [
                                'cv' => 'bi-file-person',
                                'ktp' => 'bi-card-image',
                                'ijazah' => 'bi-award',
                                'surat_lamaran' => 'bi-envelope-paper',
                                'skck' => 'bi-shield-check',
                            ];
                            foreach (($jenisBerkas ?? []) as $index => $info):
                                $warna = ['primary', 'info', 'success', 'warning', 'danger'][$index % 5];
                                $kode = $info['kode'] ?? '';
                                if ($kode === 'surat_lamaran') {
                                    continue;
                                }
                                $sudahUpload = isset($berkas[$kode]);
                            ?>
                                <div class="col-md-6">
                                    <div class="card card-bordered">
                                        <div class="card-body p-6">

                                            <!-- Header berkas -->
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="symbol symbol-40px">
                                                        <span class="symbol-label bg-light-<?= $warna ?>">
                                                            <i class="bi <?= esc($iconMap[$kode] ?? 'bi-file-earmark') ?> text-<?= $warna ?> fs-4"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold fs-6"><?= esc($info['nama_berkas']) ?></div>
                                                    </div>
                                                </div>
                                                <?php if ($sudahUpload): ?>
                                                    <span class="badge badge-light-success">
                                                        <i class="bi bi-check2 me-1"></i>Terupload
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-light-secondary">Belum Upload</span>
                                                <?php endif ?>
                                            </div>

                                            <!-- Nama file + tombol lihat -->
                                            <?php if ($sudahUpload): ?>
                                                <div class="d-flex align-items-center justify-content-between mb-4">
                                                    <span class="text-muted fs-7 text-truncate me-3">
                                                        <i class="bi bi-file-earmark me-1"></i>
                                                        <?= esc($berkas[$kode]['nama_file']) ?>
                                                    </span>
                                                    <a href="<?= base_url($berkas[$kode]['path_file']) ?>"
                                                        target="_blank"
                                                        class="btn btn-sm btn-light-primary text-nowrap">
                                                        <i class="bi bi-eye me-1"></i>Lihat
                                                    </a>
                                                </div>
                                            <?php endif ?>

                                            <!-- Info upload -->
                                            <div class="text-muted fs-8">
                                                <?php if ($sudahUpload): ?>
                                                    <i class="bi bi-check-circle text-success me-1"></i>
                                                    Berkas sudah diunggah dan dapat dilihat
                                                <?php else: ?>
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Berkas belum diunggah oleh pelamar
                                                <?php endif ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Riwayat Lamaran -->
            <div class="tab-pane fade" id="tab_lamaran">
                <div class="card">
                    <div class="card-body text-center py-15">
                        <i class="bi bi-briefcase fs-3x text-muted mb-4 d-block"></i>
                        <div class="text-muted fs-5">Belum ada riwayat lamaran</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var preferredTab = '<?= esc($selectedTab, 'js') ?>';
        var hash = window.location.hash || (preferredTab ? '#' + preferredTab : '');

        if (hash) {
            var tabEl = document.querySelector('a[href="' + hash + '"]');
            if (tabEl) {
                new bootstrap.Tab(tabEl).show();
            }
        }

        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(el) {
            el.addEventListener('shown.bs.tab', function(e) {
                history.replaceState(null, null, e.target.getAttribute('href'));
            });
        });
    });
</script>
<?= $this->endSection() ?>
