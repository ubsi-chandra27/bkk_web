<?= $this->extend('admin/layout/app') ?>

<?= $this->section('content') ?>
<?php
$nama = $user['nama'] ?? 'Admin';
$foto = $user['foto'] ?? null;
$initials = strtoupper(substr(trim($nama) !== '' ? trim($nama) : 'A', 0, 1));
$isDudi = (int) ($user['id_role'] ?? 0) === 3;
$statusBadge = ((int) ($user['is_active'] ?? 0) === 1) ? 'success' : 'danger';
$statusLabel = ((int) ($user['is_active'] ?? 0) === 1) ? 'Aktif' : 'Nonaktif';

$formatValue = static function ($value, string $fallback = '-') {
    return ($value !== null && $value !== '') ? $value : $fallback;
};

$formatDate = static function ($value, bool $withTime = false) {
    if (empty($value)) {
        return '-';
    }

    return date($withTime ? 'd M Y H:i' : 'd M Y', strtotime($value));
};

$infoItem = static function (string $label, $value, string $icon, string $color = 'primary') {
?>
    <div class="col-md-6 col-12 mb-6">
        <div class="d-flex align-items-center">
            <div class="symbol symbol-40px me-4 bg-light-<?= esc($color) ?> rounded">
                <span class="symbol-label">
                    <i class="bi <?= esc($icon) ?> fs-4 text-<?= esc($color) ?>"></i>
                </span>
            </div>
            <div class="min-w-0">
                <div class="text-muted fs-7 mb-1"><?= esc($label) ?></div>
                <div class="fw-bolder fs-6 text-gray-900 text-break"><?= esc($value !== null && $value !== '' ? $value : '-') ?></div>
            </div>
        </div>
    </div>
<?php
};
?>

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <?php if (!empty($foto)): ?>
                                <img src="<?= base_url('uploads/foto/' . $foto) ?>" alt="Foto profil" />
                            <?php else: ?>
                                <span class="symbol-label bg-light-primary text-primary fw-bolder fs-1"><?= esc($initials) ?></span>
                            <?php endif ?>
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-<?= $statusBadge ?> rounded-circle border border-4 border-white h-20px w-20px"></div>
                        </div>
                    </div>

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-gray-900 fs-2 fw-bolder me-3"><?= esc($nama) ?></span>
                                    <span class="badge badge-light-<?= $statusBadge ?>"><?= esc($statusLabel) ?></span>
                                </div>
                                <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                        <i class="bi bi-envelope me-2"></i><?= esc($formatValue($user['email'] ?? null)) ?>
                                    </span>
                                    <?php if (!empty($user['telepon'])): ?>
                                        <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                            <i class="bi bi-telephone me-2"></i><?= esc($user['telepon']) ?>
                                        </span>
                                    <?php endif ?>
                                    <span class="d-flex align-items-center text-gray-400 mb-2">
                                        <i class="bi bi-person-badge me-2"></i><?= esc($formatValue($user['nama_role'] ?? null)) ?>
                                    </span>
                                </div>
                            </div>
                            <div>
                                <a href="<?= base_url('admin/profil-saya/edit') ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square fs-6"></i> Edit Profil
                                </a>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="fs-6 fw-bold text-gray-700">Role</div>
                                <div class="fw-bold fs-6 text-gray-400"><?= esc($formatValue($user['nama_role'] ?? null)) ?></div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="fs-6 fw-bold text-gray-700">Bergabung</div>
                                <div class="fw-bold fs-6 text-gray-400"><?= esc($formatDate($user['created_at'] ?? null)) ?></div>
                            </div>
                            <?php if (!empty($user['last_login'])): ?>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fs-6 fw-bold text-gray-700">Login Terakhir</div>
                                    <div class="fw-bold fs-6 text-gray-400"><?= esc($formatDate($user['last_login'], true)) ?></div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

                <?php if ($isDudi): ?>
                    <div class="d-flex overflow-auto h-55px">
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                            <li class="nav-item">
                                <a class="nav-link text-active-primary me-6 active" data-bs-toggle="tab" href="#tab_data_diri">
                                    <i class="bi bi-person me-2"></i>Data Diri
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#tab_perusahaan">
                                    <i class="bi bi-building me-2"></i>Perusahaan
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="<?= $isDudi ? 'tab-content' : '' ?>">
            <div class="<?= $isDudi ? 'tab-pane fade show active' : '' ?>" id="tab_data_diri">
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Data Diri</h3>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="row">
                            <?php $infoItem('Nama Lengkap', $formatValue($user['nama'] ?? null), 'bi-person', 'primary'); ?>
                            <?php $infoItem('Email', $formatValue($user['email'] ?? null), 'bi-envelope', 'info'); ?>
                            <?php $infoItem('No. HP', $formatValue($user['telepon'] ?? null), 'bi-telephone', 'success'); ?>
                            <?php $infoItem('Username', $formatValue($user['email'] ?? null), 'bi-at', 'warning'); ?>
                            <?php $infoItem('Role', $formatValue($user['nama_role'] ?? null), 'bi-person-badge', 'danger'); ?>
                            <?php $infoItem('Jenis Kelamin', $formatValue($user['jenis_kelamin'] ?? null), 'bi-gender-ambiguous', 'primary'); ?>
                            <?php $infoItem('Tempat Lahir', $formatValue($user['tempat_lahir'] ?? null), 'bi-house', 'success'); ?>
                            <?php $infoItem('Tanggal Lahir', $formatDate($user['tanggal_lahir'] ?? null), 'bi-calendar', 'danger'); ?>
                            <?php $infoItem('Alamat', $formatValue($user['alamat'] ?? null), 'bi-geo-alt', 'warning'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($isDudi): ?>
                <div class="tab-pane fade" id="tab_perusahaan">
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header">
                            <div class="card-title m-0">
                                <h3 class="fw-bolder m-0">Perusahaan</h3>
                            </div>
                        </div>
                        <div class="card-body p-9">
                            <?php if (empty($perusahaan)): ?>
                                <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-warning">Data perusahaan tidak ditemukan</h4>
                                        <span>Akun ini belum terhubung dengan data perusahaan.</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="d-flex flex-wrap flex-sm-nowrap mb-8">
                                    <div class="me-7 mb-4">
                                        <div class="symbol symbol-100px symbol-lg-140px symbol-fixed position-relative">
                                            <?php if (!empty($perusahaan['logo'])): ?>
                                                <img src="<?= base_url('uploads/logo/' . $perusahaan['logo']) ?>" alt="Logo perusahaan" />
                                            <?php else: ?>
                                                <span class="symbol-label bg-light-primary">
                                                    <i class="fa-solid fa-building fs-1 text-primary"></i>
                                                </span>
                                            <?php endif ?>
                                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-<?= ((int) ($perusahaan['is_active'] ?? 0) === 1) ? 'success' : 'danger' ?> rounded-circle border border-4 border-white h-20px w-20px"></div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="text-gray-900 fs-2 fw-bolder me-3"><?= esc($formatValue($perusahaan['nama_perusahaan'] ?? null, 'Belum diisi')) ?></span>
                                            <span class="badge badge-light-<?= ((int) ($perusahaan['is_active'] ?? 0) === 1) ? 'success' : 'danger' ?>">
                                                <?= ((int) ($perusahaan['is_active'] ?? 0) === 1) ? 'Aktif' : 'Tidak Aktif' ?>
                                            </span>
                                        </div>
                                        <div class="text-gray-400 fw-bold fs-6">
                                            <?= esc($formatValue($perusahaan['bidang_usaha'] ?? null, 'Bidang usaha belum diisi')) ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="separator separator-dashed my-4"></div>

                                <div class="row">
                                    <?php $infoItem('Nama Perusahaan', $formatValue($perusahaan['nama_perusahaan'] ?? null), 'bi-building', 'primary'); ?>
                                    <?php $infoItem('Bidang Usaha', $formatValue($perusahaan['bidang_usaha'] ?? null), 'bi-briefcase', 'info'); ?>
                                    <?php $infoItem('No. Telepon', $formatValue($perusahaan['no_telepon'] ?? null), 'bi-telephone', 'success'); ?>
                                    <?php $infoItem('Email Perusahaan', $formatValue($perusahaan['email'] ?? null), 'bi-envelope', 'info'); ?>
                                    <?php $infoItem('Kota', $formatValue($perusahaan['kota'] ?? null), 'bi-geo', 'success'); ?>
                                    <?php $infoItem('Website', $formatValue($perusahaan['website'] ?? null), 'bi-globe', 'warning'); ?>
                                    <?php $infoItem('Alamat', $formatValue($perusahaan['alamat'] ?? null), 'bi-map', 'danger'); ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>