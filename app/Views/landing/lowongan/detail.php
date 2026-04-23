<?= $this->extend('landing/layout/app') ?>

<?= $this->section('styles') ?>
<style>
    .btn-company-cta:hover {
        color: #ffffff !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('hero-section') ?>
<div class="d-flex flex-column flex-center w-100 min-h-100px min-h-lg-180px px-9 text-center">
    <h1 class="text-white fw-bolder fs-2hx mb-3">Detail Lowongan</h1>
    <p class="text-white fw-semibold fs-5 opacity-75 mb-0">
        Informasi lengkap mengenai posisi pekerjaan dan syarat melamar.
    </p>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
function deadlineBadge(string $tgl): string
{
    $diff = (int) ceil((strtotime($tgl) - time()) / 86400);
    if ($diff < 0) return '<span class="badge badge-light-danger fw-bold">Ditutup</span>';
    if ($diff === 0) return '<span class="badge badge-light-warning fw-bold">Hari ini</span>';
    if ($diff <= 7) return '<span class="badge badge-light-warning fw-bold">' . $diff . ' hari lagi</span>';
    return '<span class="badge badge-light-success fw-bold">' . date('d M Y', strtotime($tgl)) . '</span>';
}
$logoUrl = !empty($lowongan['logo']) ? base_url('uploads/logo/' . $lowongan['logo']) : null;
$statusClass = strtolower($lowongan['status'] ?? '') === 'aktif' ? 'badge-light-success' : 'badge-light-secondary';
$lokasiKerja = $lowongan['lokasi_kerja'] ?? $lowongan['kota'] ?? '-';
$jenisPekerjaan = $lowongan['jenis_pekerjaan'] ?? '-';
$bidangUsaha = $lowongan['bidang_usaha'] ?? '-';
$companyUrl = site_url('perusahaan/' . ($lowongan['id_perusahaan'] ?? ''));
$applyUrl = site_url('lowongan/apply/' . ($lowongan['id'] ?? ''));
$applyText = 'Lamar Sekarang';
$applyIcon = 'bi-send-fill';
$applyClass = 'btn-primary';
$berkasKurang = $berkasKurang ?? [];
$berkasLamaran = $berkasLamaran ?? [];
$canApplyWithModal = true;

if (isset($sudahLamar) && $sudahLamar) {
    $applyUrl = '#';
    $applyText = 'Sudah Dilamar';
    $applyIcon = 'bi-check-circle';
    $applyClass = 'btn-success disabled';
    $canApplyWithModal = false;
} elseif (!session()->get('isLoggedIn')) {
    $applyUrl = site_url('login');
    $applyText = 'Login untuk Lamar';
    $applyIcon = 'bi-box-arrow-in-right';
    $applyClass = 'btn-outline-primary';
    $canApplyWithModal = false;
} elseif (!in_array(session()->get('id_role'), [4, 5])) {
    $applyUrl = '#';
    $applyText = 'Hanya untuk Pelamar';
    $applyIcon = 'bi-exclamation-triangle';
    $applyClass = 'btn-secondary disabled';
    $canApplyWithModal = false;
} elseif (!empty($berkasKurang)) {
    $applyUrl = site_url('profil/edit#tab_berkas');
    $applyText = 'Lengkapi Berkas';
    $applyIcon = 'bi-file-earmark-arrow-up';
    $applyClass = 'btn-warning';
    $canApplyWithModal = false;
}
?>

<div class="container py-12">
    <div class="d-flex justify-content-between align-items-center mb-8">
        <div>
            <a href="<?= site_url('lowongan') ?>" class="btn btn-light-primary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Lowongan
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success d-flex align-items-center p-5 mb-8">
            <div class="d-flex flex-column">
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        </div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger d-flex align-items-center p-5 mb-8">
            <div class="d-flex flex-column">
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        </div>
    <?php endif ?>

    <div class="row gx-10 gy-10">
        <div class="col-xl-8">
            <div class="card shadow-sm mb-10">
                <div class="card-body p-10">
                    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-6 mb-8">
                        <div class="d-flex align-items-center gap-6">
                            <div class="symbol symbol-70px">
                                <?php if ($logoUrl): ?>
                                    <span class="symbol-label bg-light-primary">
                                        <img src="<?= $logoUrl ?>" alt="logo perusahaan" class="w-100 h-100" style="object-fit:contain;padding:10px;" />
                                    </span>
                                <?php else: ?>
                                    <span class="symbol-label bg-light-primary text-primary fs-2 fw-bold">
                                        <?= strtoupper(substr($lowongan['nama_perusahaan'] ?? 'P', 0, 2)) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex flex-column">
                                <h2 class="text-capitalize text-gray-900 fw-bolder mb-2"><?= esc($lowongan['posisi'] ?? '-') ?></h2>
                                <div class="fs-6 text-gray-600 mb-3"><?= esc($lowongan['nama_perusahaan'] ?? '-') ?></div>
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <?php if (!empty($jenisPekerjaan)): ?>
                                        <span class="badge badge-light-info fw-bold"><?= esc($jenisPekerjaan) ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($lowongan['status'])): ?>
                                        <span class="badge <?= $statusClass ?> fw-bold"><?= esc(ucfirst($lowongan['status'])) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="text-end text-responsive">
                            <div class="fs-7 text-gray-500 mb-1">Batas Lamaran</div>
                            <div class="fs-6"><?= $lowongan['batas_lamaran'] ? deadlineBadge($lowongan['batas_lamaran']) : '<span class="badge badge-light-secondary fw-bold">Tidak ditentukan</span>' ?></div>
                        </div>
                    </div>

                    <div class="row gx-5 gy-5 mb-8">
                        <div class="col-md-3 border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="fw-semibold text-gray-600 mb-2">Lokasi Kerja</div>
                            <div class="text-gray-800"><?= esc($lokasiKerja) ?></div>
                        </div>
                        <div class="col-md-3 border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <?php
                            function formatJenisPekerjaan($jenis)
                            {
                                $map = [
                                    'fulltime' => 'Full Time',
                                    'parttime' => 'Part Time',
                                    'magang' => 'Magang',
                                    'kontrak' => 'Kontrak',
                                ];

                                return $map[$jenis] ?? ucfirst($jenis);
                            }
                            ?>
                            <div class="fw-semibold text-gray-600 mb-2">Jenis Pekerjaan</div>
                            <div class="text-gray-800"><?= esc(formatJenisPekerjaan($jenisPekerjaan)) ?></div>
                        </div>
                        <div class="col-md-3 border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="fw-semibold text-gray-600 mb-2">Status Lowongan</div>
                            <div class="text-gray-800"><span class="badge <?= $statusClass ?> fw-bold"><?= esc(ucfirst($lowongan['status'] ?? '-')) ?></span></div>
                        </div>
                    </div>

                    <?php if (!empty($jurusans)): ?>
                        <div class="mb-10">
                            <h3 class="fs-3 fw-bold text-gray-800 mb-4">Jurusan yang Direkomendasikan</h3>
                            <div class="row g-3">
                                <?php foreach ($jurusans as $jurusan): ?>
                                    <div class="col-md-6">
                                        <div class="badge badge-light-primary fs-7 fw-bold py-3 px-4 w-100 text-start">
                                            <?= esc($jurusan['kompetensi_keahlian'] ?? $jurusan['akronim'] ?? '-') ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($syaratBerkas)): ?>
                        <div class="mb-10">
                            <h3 class="fs-3 fw-bold text-gray-800 mb-4">Syarat Berkas</h3>
                            <div class="row g-3">
                                <?php foreach ($syaratBerkas as $syarat): ?>
                                    <div class="col-md-6">
                                        <div class="badge badge-light-dark fs-7 fw-bold py-3 px-4 w-100 text-start">
                                            <?= esc($syarat['nama_berkas']) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if (!empty($berkasKurang)): ?>
                                <div class="alert alert-warning d-flex align-items-start p-5 mt-5 mb-0">
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold mb-1">Berkas Anda belum lengkap untuk melamar lowongan ini.</span>
                                        <span><?= esc(implode(', ', $berkasKurang)) ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex flex-column flex-sm-row gap-3 mb-8">
                        <?php if ($canApplyWithModal): ?>
                            <button type="button" class="btn <?= $applyClass ?> btn-lg" data-bs-toggle="modal" data-bs-target="#modalLamarSekarang">
                                <i class="bi <?= $applyIcon ?> me-2"></i><?= $applyText ?>
                            </button>
                        <?php else: ?>
                            <a href="<?= $applyUrl ?>" class="btn <?= $applyClass ?> btn-lg">
                                <i class="bi <?= $applyIcon ?> me-2"></i><?= $applyText ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($sudahLamar) && !empty($berkasLamaran)): ?>
                        <div class="border border-gray-300 border-dashed rounded p-6">
                            <div class="d-flex align-items-center justify-content-between gap-4 flex-wrap">
                                <div>
                                    <div class="fs-5 fw-bold text-gray-900 mb-1">Berkas Lamaran</div>
                                    <div class="text-muted fs-7">File yang Anda kirim saat melamar lowongan ini.</div>
                                </div>
                                <span class="badge badge-light-success fw-bold">Sudah Diunggah</span>
                            </div>

                            <div class="mt-5 d-flex flex-column gap-4">
                                <?php foreach ($berkasLamaran as $item): ?>
                                    <div class="d-flex align-items-center justify-content-between gap-4 flex-wrap bg-light rounded px-5 py-4">
                                        <div>
                                            <div class="fw-semibold text-gray-900"><?= esc($item['nama_berkas'] ?? 'Berkas Lamaran') ?></div>
                                            <div class="text-muted fs-7"><?= esc($item['file_name'] ?? '-') ?></div>
                                        </div>
                                        <a href="<?= base_url($item['file_path']) ?>" target="_blank" class="btn btn-light-primary btn-sm">
                                            <i class="bi bi-eye me-2"></i>Lihat Berkas
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <div class="card shadow-sm mb-10">
                <div class="card-body p-10">
                    <div class="mb-10">
                        <h3 class="fs-3 fw-bold text-gray-800 mb-4">Deskripsi Pekerjaan</h3>
                        <div class="fs-6 text-gray-700 "><?= nl2br(esc($lowongan['deskripsi_pekerjaan'] ?? 'Belum ada deskripsi pekerjaan.')) ?></div>
                    </div>

                    <div>
                                <h3 class="fs-3 fw-bold text-gray-800 mb-4">Kualifikasi & Persyaratan</h3>
                                <div class="fs-6 text-gray-700"><?= nl2br(esc($lowongan['kualifikasi'] ?? 'Belum ada kualifikasi terdaftar.')) ?></div>
                            </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card shadow-sm">
                <div class="card-body p-10">
                    <div class="d-flex align-items-center gap-6 mb-8">
                        <div class="symbol symbol-70px">
                            <?php if ($logoUrl): ?>
                                <span class="symbol-label bg-light-primary">
                                    <img src="<?= $logoUrl ?>" alt="logo perusahaan" class="w-100 h-100" style="object-fit:contain;padding:10px;" />
                                </span>
                            <?php else: ?>
                                <span class="symbol-label bg-light-primary text-primary fs-2 fw-bold">
                                    <?= strtoupper(substr($lowongan['nama_perusahaan'] ?? 'P', 0, 2)) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="fs-7 text-gray-500">Perusahaan</div>
                            <div class="fs-5 fw-bold text-gray-900"><?= esc($lowongan['nama_perusahaan'] ?? '-') ?></div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="fw-semibold text-gray-600 mb-2">Bidang Usaha</div>
                        <div class="text-gray-800"><?= esc($bidangUsaha) ?></div>
                    </div>

                    <div class="mb-6">
                        <div class="fw-semibold text-gray-600 mb-2">Lokasi</div>
                        <div class="text-gray-800"><?= esc($lokasiKerja) ?></div>
                    </div>

                    <div class="mb-6">
                        <div class="fw-semibold text-gray-600 mb-2">Email</div>
                        <div class="text-gray-800"><?= esc($lowongan['email_perusahaan'] ?? '-') ?></div>
                    </div>

                    <a href="<?= esc($companyUrl) ?>" class="btn btn-outline-primary btn-company-cta w-100 mt-6 fs-7">
                        <i class="bi bi-building me-2"></i>Lihat Lowongan Perusahaan Ini
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($canApplyWithModal): ?>
    <div class="modal fade" id="modalLamarSekarang" tabindex="-1" aria-labelledby="modalLamarSekarangLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?= site_url('lowongan/apply/' . ($lowongan['id'] ?? '')) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h3 class="modal-title fs-4 fw-bold" id="modalLamarSekarangLabel">Upload Surat Lamaran</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-5">
                            <div class="text-gray-800 fw-semibold mb-2"><?= esc($lowongan['posisi'] ?? '-') ?></div>
                            <div class="text-muted"><?= esc($lowongan['nama_perusahaan'] ?? '-') ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="surat_lamaran" class="form-label fw-semibold">File Surat Lamaran</label>
                            <input type="file" class="form-control" id="surat_lamaran" name="surat_lamaran" accept=".pdf,.doc,.docx" required>
                            <div class="form-text">Format file: PDF, DOC, atau DOCX. Maksimal 2 MB.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send-fill me-2"></i>Kirim Lamaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
