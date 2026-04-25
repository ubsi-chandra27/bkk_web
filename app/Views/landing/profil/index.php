<?= $this->extend('landing/layout/app') ?>
<?= $this->section('title') ?>Profil Saya<?= $this->endSection() ?>

<?= $this->section('hero-section') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$foto       = $pelamar['foto'] ?? null;
$fotoSrc    = $foto ? base_url('uploads/foto/' . $foto) : base_url('assets/media/avatars/blank.png');
$isActive   = $user['is_active'] ?? 0;
$isAlumni   = ($user['id_role'] ?? 0) == 4;
$statusPendaftaran = strtolower((string) ($pelamar['status_pendaftaran'] ?? 'menunggu_aktivasi'));
$statusPendaftaranLabel = 'Menunggu Aktivasi';
$statusPendaftaranBadge = 'warning';

if ($statusPendaftaran === 'terdaftar') {
    $statusPendaftaranLabel = 'Terdaftar';
    $statusPendaftaranBadge = 'info';
} elseif ($statusPendaftaran === 'aktif') {
    $statusPendaftaranLabel = 'Aktif';
    $statusPendaftaranBadge = 'success';
}
?>

<!-- ============================================================
     PROFIL HEADER CARD  (gaya halaman profil admin Metronic)
============================================================ -->
<div class="container py-10">

    <div class="card shadow-sm mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">

            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">

                <!-- ===== Foto ===== -->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="<?= $fotoSrc ?>" alt="foto profil" />
                        <!-- Status dot -->
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6
                                    bg-<?= $isActive ? 'success' : 'danger' ?>
                                    rounded-circle border border-4 border-white h-20px w-20px">
                        </div>
                    </div>
                </div>

                <!-- ===== Info Utama ===== -->
                <div class="flex-grow-1">

                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">

                            <!-- Nama + badge status -->
                            <div class="d-flex align-items-center mb-2">
                                <span class="text-gray-900 fs-2 fw-bolder me-3">
                                    <?= esc($user['nama']) ?>
                                </span>
                                <span class="badge badge-light-<?= $isActive ? 'success' : 'danger' ?>">
                                    <?= $isActive ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </div>

                            <!-- Info kontak -->
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                    <i class="bi bi-envelope me-2 fs-5"></i>
                                    <?= esc($user['email']) ?>
                                </span>
                                <?php if (!empty($pelamar['telepon'])): ?>
                                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                        <i class="bi bi-telephone me-2 fs-5"></i>
                                        <?= esc($pelamar['telepon']) ?>
                                    </span>
                                <?php endif ?>
                                <?php if (!empty($pelamar['alamat'])): ?>
                                    <span class="d-flex align-items-center text-gray-400 mb-2">
                                        <i class="bi bi-geo-alt me-2 fs-5"></i>
                                        <?= esc($pelamar['alamat']) ?>
                                    </span>
                                <?php endif ?>
                            </div>
                        </div>

                        <!-- Tombol Edit -->
                        <div class="d-flex my-4">
                            <a href="<?= site_url('profil/edit') ?>"
                                class="btn btn-sm btn-primary me-2">
                                <i class="bi bi-pencil me-1"></i>Edit Profil
                            </a>
                        </div>
                    </div>

                    <!-- Stats / Info ringkas -->
                    <div class="d-flex flex-wrap flex-stack">
                        <div class="d-flex flex-wrap">

                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="fs-7 text-gray-500 fw-semibold">Bergabung</div>
                                <div class="fs-6 fw-bold text-gray-800">
                                    <?= date('d M Y', strtotime($user['created_at'])) ?>
                                </div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="fs-7 text-gray-500 fw-semibold">Status Pendaftaran</div>
                                <div class="fs-6 fw-bold text-gray-800">
                                    <span class="badge badge-light-<?= $statusPendaftaranBadge ?>">
                                        <?= esc($statusPendaftaranLabel) ?>
                                    </span>
                                </div>
                            </div>
                            <?php if ($isAlumni && !empty($alumni)): ?>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fs-7 text-gray-500 fw-semibold">Jurusan</div>
                                    <div class="fs-6 fw-bold text-gray-800">
                                        <?= esc($alumni['akronim'] ?? '-') ?>
                                    </div>
                                </div>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fs-7 text-gray-500 fw-semibold">Angkatan</div>
                                    <div class="fs-6 fw-bold text-gray-800">
                                        <?= esc($alumni['tahun'] ?? '-') ?>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ===== Tab Nav ===== -->
            <div class="d-flex overflow-auto h-55px">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 active"
                            data-bs-toggle="tab" href="#tab_data_diri">
                            <i class="bi bi-person me-2"></i>Data Diri
                        </a>
                    </li>
                    <?php if ($isAlumni): ?>
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

    <!-- ============================================================
         TAB CONTENT
    ============================================================ -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible mb-5">
            <i class="bi bi-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <div class="tab-content">

        <!-- ===== TAB DATA DIRI ===== -->
        <div class="tab-pane fade show active" id="tab_data_diri">
            <div class="row g-6">

                <!-- Informasi Pribadi -->
                <div class="col-lg-12">
                    <div class="card shadow-sm card-flush">
                        <div class="card-header cursor-pointer border-bottom">
                            <div class="card-title m-0">
                                <h3 class="fw-bolder m-0">Informasi Pribadi</h3>
                            </div>
                        </div>
                        <div class="card-body p-9">
                            <div class="row">

                                <?php
                                $fields = [
                                    ['label' => 'Nama Lengkap',  'value' => $user['nama'],              'icon' => 'bi-person',           'color' => 'primary'],
                                    ['label' => 'Email',          'value' => $user['email'],             'icon' => 'bi-envelope',         'color' => 'info'],
                                    ['label' => 'Status Pendaftaran', 'value' => $statusPendaftaranLabel, 'icon' => 'bi-patch-check', 'color' => $statusPendaftaranBadge],
                                    ['label' => 'No. Telepon',    'value' => $pelamar['telepon'] ?? '-', 'icon' => 'bi-telephone',        'color' => 'success'],
                                    ['label' => 'Alamat',         'value' => $pelamar['alamat'] ?? '-',  'icon' => 'bi-geo-alt',          'color' => 'warning'],
                                    ['label' => 'Tanggal Lahir',  'value' => !empty($pelamar['tanggal_lahir'])
                                        ? date('d F Y', strtotime($pelamar['tanggal_lahir'])) : '-',     'icon' => 'bi-calendar',         'color' => 'danger'],
                                    ['label' => 'Jenis Kelamin',  'value' => (function () use ($pelamar) {
                                        $jk = $pelamar['jenis_kelamin'] ?? '-';
                                        return $jk === 'L' ? 'Laki-laki' : ($jk === 'P' ? 'Perempuan' : '-');
                                    })(),                                                                'icon' => 'bi-gender-ambiguous', 'color' => 'primary'],
                                ];
                                if (!empty($pelamar['nomer_nik'])) {
                                    $fields[] = ['label' => 'NIK', 'value' => $pelamar['nomer_nik'], 'icon' => 'bi-card-text', 'color' => 'dark'];
                                }
                                foreach ($fields as $f): ?>
                                    <div class="col-md-6 mb-7">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light-<?= $f['color'] ?>">
                                                    <i class="bi <?= $f['icon'] ?> text-<?= $f['color'] ?> fs-4"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-muted fs-7 mb-1"><?= $f['label'] ?></div>
                                                <div class="fw-bolder fs-6"><?= esc($f['value']) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== TAB TRACER ALUMNI ===== -->
        <?php if ($isAlumni): ?>
            <div class="tab-pane fade" id="tab_tracer">
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
                                <?php if (empty($tracer)): ?>
                                    <div class="card-toolbar">
                                        <a href="<?= site_url('profil/edit#tab_tracer') ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-plus me-1"></i>Isi Data Tracer
                                        </a>
                                    </div>
                                <?php endif ?>
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
                                        <a href="<?= site_url('profil/edit#tab_tracer') ?>" class="btn btn-primary">
                                            <i class="bi bi-plus me-2"></i>Isi Data Tracer
                                        </a>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif ?>

        <!-- ===== TAB BERKAS ===== -->
        <div class="tab-pane fade" id="tab_berkas">
            <div class="card shadow-sm card-flush">
                <div class="card-header border-bottom">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">Berkas Dokumen</h3>
                    </div>
                </div>
                <div class="card-body p-9">
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

                                        <!-- Form upload -->
                                        <form action="<?= site_url('pelamar/profil/upload-berkas') ?>"
                                            method="POST" enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_jenis_berkas" value="<?= esc($info['id']) ?>" />
                                            <div class="d-flex gap-2">
                                                <input type="file" name="berkas"
                                                    class="form-control form-control-sm"
                                                    accept=".pdf,.jpg,.jpeg,.png" />
                                                <button type="submit"
                                                    class="btn btn-sm btn-<?= $warna ?> text-nowrap">
                                                    <?= $sudahUpload ? 'Ganti' : 'Upload' ?>
                                                </button>
                                            </div>
                                            <div class="text-muted fs-8 mt-2">
                                                <i class="bi bi-info-circle me-1"></i>PDF, JPG, PNG · Maks 2MB
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== TAB RIWAYAT LAMARAN ===== -->
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
    <!-- END TAB CONTENT -->

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Aktifkan tab dari hash URL (misal: /profil#tab_berkas)
    document.addEventListener('DOMContentLoaded', function() {
        var hash = window.location.hash;
        if (hash) {
            var tabEl = document.querySelector('a[href="' + hash + '"]');
            if (tabEl) new bootstrap.Tab(tabEl).show();
        }

        // Update hash saat tab diklik
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(el) {
            el.addEventListener('shown.bs.tab', function(e) {
                history.replaceState(null, null, e.target.getAttribute('href'));
            });
        });
    });
</script>
<?= $this->endSection() ?>