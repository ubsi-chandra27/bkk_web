<?= $this->extend('admin/layout/app') ?>
<?= $this->section('content') ?>
<?php
$statusPendaftaran = strtolower((string) ($pelamar['status_pendaftaran'] ?? 'menunggu_aktivasi'));
$statusPendaftaranLabel = 'Menunggu Aktivasi';
$statusPendaftaranBadge = 'warning';
$berkasLamaran = $berkasLamaran ?? [];
$selectedLamaran = $selectedLamaran ?? null;
$selectedTab = $selectedTab ?? '';
$canManageRiwayatKerja = (int) session()->get('id_role') !== 3;

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
                                data-bs-toggle="tab" href="#tab_riwayat_kerja">
                                <i class="bi bi-building me-2"></i>Riwayat Kerja
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

            <!-- Tab Riwayat Kerja -->
            <div class="tab-pane fade" id="tab_riwayat_kerja">
                <div class="card shadow-sm card-flush" id="kt_admin_riwayat_kerja_card">
                    <div class="card-header border-bottom">
                        <div class="card-title">
                            <h3 class="fw-bolder m-0">Riwayat Kerja</h3>
                        </div>
                        <?php if ($canManageRiwayatKerja): ?>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-primary" id="btnTambahRiwayatKerja">
                                    <i class="bi bi-plus-lg me-1"></i>Tambah
                                </button>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="card-body p-9">
                        <div id="riwayatKerjaAlert" class="alert alert-danger d-none mb-6"></div>
                        <div id="riwayatKerjaList" class="d-flex flex-column gap-5">
                            <div class="text-center py-15">
                                <span class="spinner-border spinner-border-sm text-primary me-2"></span>
                                <span class="text-muted fs-6">Memuat riwayat kerja...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Riwayat Lamaran -->
            <div class="tab-pane fade" id="tab_lamaran">
                <div class="card shadow-sm card-flush">
                    <div class="card-header border-bottom">
                        <div class="card-title">
                            <h3 class="fw-bolder m-0">Riwayat Lamaran</h3>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <?php if (!empty($lamaran)): ?>
                            <div class="d-flex flex-column gap-5">
                                <?php foreach ($lamaran as $l):
                                    $statusMap = [
                                        'menunggu_diverifikasi' => ['color' => 'warning',  'label' => 'Menunggu'],
                                        'diproses'              => ['color' => 'info',     'label' => 'Diproses'],
                                        'lolos_verifikasi'      => ['color' => 'primary',  'label' => 'Lolos Verifikasi'],
                                        'wawancara'             => ['color' => 'dark',     'label' => 'Wawancara'],
                                        'diterima'              => ['color' => 'success',  'label' => 'Diterima'],
                                        'ditolak'               => ['color' => 'danger',   'label' => 'Ditolak'],
                                    ];
                                    $st = $statusMap[$l['status']] ?? ['color' => 'secondary', 'label' => $l['status']];
                                    $detailLowonganUrl = !empty($l['id_lowongan']) ? site_url('lowongan/' . $l['id_lowongan']) : null;
                                ?>
                                    <div class="card card-bordered">
                                        <div class="card-body p-6">
                                            <div class="d-flex align-items-start justify-content-between gap-3">

                                                <!-- Logo + Info lowongan -->
                                                <div class="d-flex align-items-center gap-4">
                                                    <div class="symbol symbol-50px">
                                                        <?php if (!empty($l['logo'])): ?>
                                                            <span class="symbol-label bg-light-primary">
                                                                <img src="<?= base_url('uploads/logo/' . $l['logo']) ?>"
                                                                    alt="logo" class="w-100 h-100 object-fit-contain p-1" />
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="symbol-label bg-light-primary text-primary fs-4 fw-bold">
                                                                <?= strtoupper(substr($l['nama_perusahaan'] ?? 'P', 0, 2)) ?>
                                                            </span>
                                                        <?php endif ?>
                                                    </div>
                                                    <div>
                                                        <?php if ($detailLowonganUrl): ?>
                                                            <a href="<?= $detailLowonganUrl ?>" class="fw-bolder fs-5 text-gray-900 text-hover-primary mb-1 d-inline-block">
                                                                <?= esc($l['posisi']) ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <div class="fw-bolder fs-5 text-gray-900 mb-1">
                                                                <?= esc($l['posisi']) ?>
                                                            </div>
                                                        <?php endif ?>
                                                        <div class="text-primary fw-semibold fs-7 mb-1">
                                                            <i class="bi bi-building me-1"></i>
                                                            <?= esc($l['nama_perusahaan'] ?? '-') ?>
                                                        </div>
                                                        <div class="text-muted fs-8">
                                                            <i class="bi bi-calendar me-1"></i>
                                                            Melamar: <?= date('d M Y', strtotime($l['tanggal_melamar'])) ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Badge status -->
                                                <span class="badge badge-light-<?= $st['color'] ?> px-4 py-2 text-nowrap">
                                                    <?= $st['label'] ?>
                                                </span>

                                            </div>

                                            <!-- Catatan admin (jika ada) -->
                                            <?php if (!empty($l['catatan'])): ?>
                                                <div class="mt-4 p-4 bg-light rounded">
                                                    <div class="text-muted fs-7 fw-semibold mb-1">
                                                        <i class="bi bi-chat-left-text me-1"></i>Catatan dari Admin:
                                                    </div>
                                                    <div class="fs-6 text-gray-800"><?= esc($l['catatan']) ?></div>
                                                </div>
                                            <?php endif ?>

                                            <?php if ($detailLowonganUrl): ?>
                                                <div class="mt-4">
                                                    <a href="<?= $detailLowonganUrl ?>" class="btn btn-sm btn-light-primary">
                                                        <i class="bi bi-box-arrow-up-right me-2"></i>Detail Lowongan
                                                    </a>
                                                </div>
                                            <?php endif ?>

                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-15">
                                <i class="bi bi-briefcase fs-3x text-gray-400 mb-5 d-block"></i>
                                <div class="text-muted fs-5 mb-5">Belum ada riwayat lamaran</div>
                                <a href="<?= site_url('lowongan') ?>" class="btn btn-primary">
                                    <i class="bi bi-search me-2"></i>Cari Lowongan
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="modalRiwayatKerja" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content" data-kt-riwayat-kerja-modal="true">
                    <form id="formRiwayatKerja" class="form">
                        <div class="modal-header">
                            <h2 class="fw-bolder" id="modalRiwayatKerjaTitle">Tambah Riwayat Kerja</h2>
                            <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg fs-4"></i>
                            </button>
                        </div>
                        <div class="modal-body py-10 px-lg-17">
                            <input type="hidden" name="id" id="riwayatKerjaId">

                            <div class="row g-6">
                                <div class="col-md-6">
                                    <label class="required form-label">Nama Perusahaan</label>
                                    <input type="text" name="nama_perusahaan" id="namaPerusahaan" class="form-control form-control-solid" maxlength="150" required>
                                    <div class="invalid-feedback" data-error-for="nama_perusahaan"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required form-label">Posisi / Jabatan</label>
                                    <input type="text" name="posisi_jabatan" id="posisiJabatan" class="form-control form-control-solid" maxlength="100" required>
                                    <div class="invalid-feedback" data-error-for="posisi_jabatan"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" id="tanggalMulai" class="form-control form-control-solid" required>
                                    <div class="invalid-feedback" data-error-for="tanggal_mulai"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" id="tanggalSelesai" class="form-control form-control-solid">
                                    <div class="invalid-feedback" data-error-for="tanggal_selesai"></div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_masih_bekerja" id="isMasihBekerja">
                                        <label class="form-check-label fw-semibold" for="isMasihBekerja">
                                            Masih bekerja di perusahaan ini
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Deskripsi Kerja</label>
                                    <textarea name="deskripsi_kerja" id="deskripsiKerja" class="form-control form-control-solid" rows="4" maxlength="2000"></textarea>
                                    <div class="invalid-feedback" data-error-for="deskripsi_kerja"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btnSimpanRiwayatKerja">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Menyimpan...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
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
        var csrfHash = '<?= csrf_hash() ?>';
        var csrfHeader = '<?= csrf_header() ?>';
        var riwayatKerjaUrl = '<?= site_url('admin/data-pelamar/profil/' . $user['id'] . '/riwayat-kerja') ?>';
        var canManageRiwayatKerja = <?= $canManageRiwayatKerja ? 'true' : 'false' ?>;
        var riwayatKerjaLoaded = false;
        var riwayatKerjaData = new Map();
        var modalEl = document.getElementById('modalRiwayatKerja');
        var modal = modalEl ? new bootstrap.Modal(modalEl) : null;
        var form = document.getElementById('formRiwayatKerja');
        var listEl = document.getElementById('riwayatKerjaList');
        var alertEl = document.getElementById('riwayatKerjaAlert');
        var submitBtn = document.getElementById('btnSimpanRiwayatKerja');
        var tanggalSelesai = document.getElementById('tanggalSelesai');
        var isMasihBekerja = document.getElementById('isMasihBekerja');

        function escapeHtml(value) {
            return String(value || '').replace(/[&<>"']/g, function(char) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[char];
            });
        }

        function formatTanggal(value) {
            if (!value) return '-';
            var parts = String(value).split('-');
            if (parts.length !== 3) return value;
            return parts[2] + '/' + parts[1] + '/' + parts[0];
        }

        function updateCsrf(response) {
            if (response && response.csrfHash) {
                csrfHash = response.csrfHash;
            }
        }

        function showAlert(message) {
            if (!alertEl) return;
            alertEl.textContent = message;
            alertEl.classList.remove('d-none');
        }

        function hideAlert() {
            if (!alertEl) return;
            alertEl.textContent = '';
            alertEl.classList.add('d-none');
        }

        function showNotification(icon, message) {
            if (window.Swal) {
                Swal.fire({
                    text: message,
                    icon: icon,
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            alert(message);
        }

        function setSubmitLoading(isLoading) {
            if (!submitBtn) return;
            submitBtn.disabled = isLoading;
            submitBtn.setAttribute('data-kt-indicator', isLoading ? 'on' : 'off');
        }

        function resetValidation() {
            if (!form) return;
            form.querySelectorAll('.is-invalid').forEach(function(el) {
                el.classList.remove('is-invalid');
            });
            form.querySelectorAll('[data-error-for]').forEach(function(el) {
                el.textContent = '';
            });
        }

        function showValidation(errors) {
            resetValidation();
            Object.keys(errors || {}).forEach(function(field) {
                var input = form.querySelector('[name="' + field + '"]');
                var feedback = form.querySelector('[data-error-for="' + field + '"]');
                if (input) input.classList.add('is-invalid');
                if (feedback) feedback.textContent = errors[field];
            });
        }

        function syncTanggalSelesaiState() {
            if (!tanggalSelesai || !isMasihBekerja) return;
            if (isMasihBekerja.checked) {
                tanggalSelesai.value = '';
                tanggalSelesai.disabled = true;
            } else {
                tanggalSelesai.disabled = false;
            }
        }

        function renderLoading() {
            listEl.innerHTML = '<div class="text-center py-15"><span class="spinner-border spinner-border-sm text-primary me-2"></span><span class="text-muted fs-6">Memuat riwayat kerja...</span></div>';
        }

        function renderEmpty() {
            var createButton = canManageRiwayatKerja ? '<button type="button" class="btn btn-primary" data-action="create"><i class="bi bi-plus-lg me-2"></i>Tambah Riwayat Kerja</button>' : '';
            listEl.innerHTML = '<div class="text-center py-15"><i class="bi bi-building fs-3x text-gray-400 mb-5 d-block"></i><div class="text-muted fs-5 mb-5">Belum ada riwayat kerja</div>' + createButton + '</div>';
        }

        function renderList(items) {
            riwayatKerjaData = new Map();

            if (!items.length) {
                renderEmpty();
                return;
            }

            listEl.innerHTML = items.map(function(item) {
                riwayatKerjaData.set(String(item.id), item);
                var periodeAkhir = String(item.is_masih_bekerja) === '1' ? 'Sekarang' : formatTanggal(item.tanggal_selesai);
                var deskripsi = item.deskripsi_kerja ? escapeHtml(item.deskripsi_kerja).replace(/\n/g, '<br>') : '<span class="text-muted">Tidak ada deskripsi</span>';
                var actionButtons = canManageRiwayatKerja ? '<div class="d-flex gap-2">' +
                    '<button type="button" class="btn btn-sm btn-light-primary" data-action="edit" data-id="' + item.id + '"><i class="bi bi-pencil me-1"></i>Edit</button>' +
                    '<button type="button" class="btn btn-sm btn-light-danger" data-action="delete" data-id="' + item.id + '"><i class="bi bi-trash me-1"></i>Hapus</button>' +
                    '</div>' : '';

                return '<div class="card card-bordered">' +
                    '<div class="card-body p-6">' +
                    '<div class="d-flex flex-column flex-md-row align-items-md-start justify-content-between gap-4">' +
                    '<div class="d-flex align-items-start gap-4">' +
                    '<div class="symbol symbol-45px">' +
                    '<span class="symbol-label bg-light-primary"><i class="bi bi-building text-primary fs-3"></i></span>' +
                    '</div>' +
                    '<div>' +
                    '<div class="fw-bolder fs-5 text-gray-900 mb-1">' + escapeHtml(item.nama_perusahaan) + '</div>' +
                    '<div class="text-primary fw-semibold fs-7 mb-2">' + escapeHtml(item.posisi_jabatan) + '</div>' +
                    '<span class="badge badge-light-info"><i class="bi bi-calendar3 me-1"></i>' + escapeHtml(formatTanggal(item.tanggal_mulai)) + ' - ' + escapeHtml(periodeAkhir) + '</span>' +
                    '</div>' +
                    '</div>' +
                    actionButtons +
                    '</div>' +
                    '<div class="separator separator-dashed my-5"></div>' +
                    '<div class="text-gray-700 fs-6">' + deskripsi + '</div>' +
                    '</div>' +
                    '</div>';
            }).join('');
        }

        function requestJson(url, options) {
            var requestOptions = options || {};
            requestOptions.headers = Object.assign({
                'X-Requested-With': 'XMLHttpRequest',
                [csrfHeader]: csrfHash
            }, requestOptions.headers || {});

            return fetch(url, requestOptions)
                .then(function(response) {
                    return response.json()
                        .catch(function() {
                            return {
                                success: false,
                                message: 'Response server tidak valid'
                            };
                        })
                        .then(function(json) {
                            updateCsrf(json);
                            if (!response.ok || !json.success) {
                                var error = new Error(json.message || 'Request gagal diproses');
                                error.payload = json;
                                throw error;
                            }
                            return json;
                        });
                });
        }

        function loadRiwayatKerja(force) {
            if (!force && riwayatKerjaLoaded) return;
            hideAlert();
            renderLoading();

            requestJson(riwayatKerjaUrl)
                .then(function(response) {
                    riwayatKerjaLoaded = true;
                    renderList(response.data || []);
                })
                .catch(function(error) {
                    showAlert(error.message);
                    renderEmpty();
                });
        }

        function openCreateModal() {
            form.reset();
            document.getElementById('riwayatKerjaId').value = '';
            document.getElementById('modalRiwayatKerjaTitle').textContent = 'Tambah Riwayat Kerja';
            resetValidation();
            syncTanggalSelesaiState();
            modal.show();
        }

        function openEditModal(id) {
            var item = riwayatKerjaData.get(String(id));
            if (!item) return;

            form.reset();
            resetValidation();
            document.getElementById('modalRiwayatKerjaTitle').textContent = 'Edit Riwayat Kerja';
            document.getElementById('riwayatKerjaId').value = item.id;
            document.getElementById('namaPerusahaan').value = item.nama_perusahaan || '';
            document.getElementById('posisiJabatan').value = item.posisi_jabatan || '';
            document.getElementById('tanggalMulai').value = item.tanggal_mulai || '';
            document.getElementById('tanggalSelesai').value = item.tanggal_selesai || '';
            document.getElementById('deskripsiKerja').value = item.deskripsi_kerja || '';
            isMasihBekerja.checked = String(item.is_masih_bekerja) === '1';
            syncTanggalSelesaiState();
            modal.show();
        }

        function submitRiwayatKerja(e) {
            e.preventDefault();
            resetValidation();
            syncTanggalSelesaiState();

            var id = document.getElementById('riwayatKerjaId').value;
            var payload = {
                nama_perusahaan: document.getElementById('namaPerusahaan').value,
                posisi_jabatan: document.getElementById('posisiJabatan').value,
                tanggal_mulai: document.getElementById('tanggalMulai').value,
                tanggal_selesai: tanggalSelesai.disabled ? '' : tanggalSelesai.value,
                is_masih_bekerja: isMasihBekerja.checked ? '1' : '0',
                deskripsi_kerja: document.getElementById('deskripsiKerja').value
            };

            setSubmitLoading(true);
            requestJson(id ? riwayatKerjaUrl + '/' + id : riwayatKerjaUrl, {
                    method: id ? 'PUT' : 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(function(response) {
                    modal.hide();
                    showNotification('success', response.message);
                    loadRiwayatKerja(true);
                })
                .catch(function(error) {
                    if (error.payload && error.payload.errors) {
                        showValidation(error.payload.errors);
                        return;
                    }
                    showNotification('error', error.message);
                })
                .finally(function() {
                    setSubmitLoading(false);
                });
        }

        function deleteRiwayatKerja(id) {
            var item = riwayatKerjaData.get(String(id));
            var namaPerusahaan = item ? item.nama_perusahaan : 'riwayat kerja ini';
            var confirmDelete = function(callback) {
                if (window.Swal) {
                    Swal.fire({
                        text: 'Hapus riwayat kerja di ' + namaPerusahaan + '?',
                        icon: 'warning',
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                        customClass: {
                            confirmButton: 'btn btn-danger',
                            cancelButton: 'btn btn-light'
                        }
                    }).then(function(result) {
                        if (result.isConfirmed) callback();
                    });
                    return;
                }

                if (confirm('Hapus riwayat kerja di ' + namaPerusahaan + '?')) callback();
            };

            confirmDelete(function() {
                requestJson(riwayatKerjaUrl + '/' + id, {
                        method: 'DELETE'
                    })
                    .then(function(response) {
                        showNotification('success', response.message);
                        loadRiwayatKerja(true);
                    })
                    .catch(function(error) {
                        showNotification('error', error.message);
                    });
            });
        }

        if (hash) {
            var tabEl = document.querySelector('a[href="' + hash + '"]');
            if (tabEl) {
                new bootstrap.Tab(tabEl).show();
            }
        }

        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(el) {
            el.addEventListener('shown.bs.tab', function(e) {
                var target = e.target.getAttribute('href');
                history.replaceState(null, null, target);
                if (target === '#tab_riwayat_kerja') {
                    loadRiwayatKerja();
                }
            });
        });

        if (hash === '#tab_riwayat_kerja') {
            loadRiwayatKerja();
        }

        if (canManageRiwayatKerja) {
            document.getElementById('btnTambahRiwayatKerja').addEventListener('click', openCreateModal);
            isMasihBekerja.addEventListener('change', syncTanggalSelesaiState);
            form.addEventListener('submit', submitRiwayatKerja);
        }
        listEl.addEventListener('click', function(e) {
            var button = e.target.closest('[data-action]');
            if (!button) return;
            if (!canManageRiwayatKerja) return;

            if (button.dataset.action === 'create') {
                openCreateModal();
            }

            if (button.dataset.action === 'edit') {
                openEditModal(button.dataset.id);
            }

            if (button.dataset.action === 'delete') {
                deleteRiwayatKerja(button.dataset.id);
            }
        });
    });
</script>
<?= $this->endSection() ?>
