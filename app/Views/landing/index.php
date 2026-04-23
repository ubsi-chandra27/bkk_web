<?= $this->extend('landing/layout/app') ?>

<?php
// ----------------------------------------------------------------
// Helper deadline badge — pakai field batas_lamaran dari tb_lowongan
// ----------------------------------------------------------------
function deadlineBadge(string $tgl): string
{
    $diff = (int) ceil((strtotime($tgl) - time()) / 86400);
    if ($diff < 0)  return '<span class="badge badge-light-danger fw-bold">Ditutup</span>';
    if ($diff <= 7) return '<span class="badge badge-light-warning fw-bold">' . $diff . ' hari lagi</span>';
    return '<span class="badge badge-light-success fw-bold">' . date('d M Y', strtotime($tgl)) . '</span>';
}
?>

<!-- ============================================================
     HERO SECTION
============================================================ -->
<?= $this->section('hero-section') ?>
<div class="d-flex flex-column flex-center w-100 min-h-400px min-h-lg-500px px-9">

    <!-- Heading -->
    <div class="text-center mb-3 mb-lg-5 py-6 py-lg-10">
        <h1 class="text-white lh-base fw-bolder fs-2hx mb-6">
            Selamat Datang di BKK &amp; Tracer Study<br />
            SMK Teratai Putih Global 4<br />
            dengan
            <span style="background:linear-gradient(to right,#12CE5D 0%,#FFD80C 100%);
                         background-clip:text;-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                <span id="kt_landing_hero_text">Tracer Alumni</span>
            </span>
        </h1>
        <p class="text-white fs-5 fw-semibold opacity-75 mb-0">
            Platform terpadu pengelolaan bursa kerja, penelusuran karir alumni,<br class="d-none d-lg-block" />
            dan kemitraan dengan industri secara digital.
        </p>
    </div>

    <!-- CTA -->
    <div class="d-flex gap-3 mb-10">
        <a href="<?= site_url('lowongan') ?>" class="btn btn-primary btn-lg">
            <i class="bi bi-briefcase me-2"></i>Lihat Lowongan
        </a>
        <a href="<?= site_url('register') ?>" class="btn btn-light btn-lg">
            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
        </a>
    </div>

    <!-- Statistik -->
    <div class="d-flex flex-center flex-nowrap gap-3 gap-md-8 gap-lg-12 overflow-auto px-2">
        <?php
        $stats = [
            ['icon' => 'bi bi-briefcase-fill',   'value' => $totalLowongan ?? 0,   'label' => 'Lowongan Aktif'],
            ['icon' => 'fas fa-building',    'value' => $totalPerusahaan ?? 0, 'label' => 'Perusahaan Mitra'],
            ['icon' => 'bi bi-people-fill',       'value' => ($totalPelamar ?? 0) . '+', 'label' => 'Pencari Kerja'],
            ['icon' => 'fas fa-user-graduate',  'value' => ($totalAlumni ?? 0) . '+',  'label' => 'Alumni Terdaftar'],
        ];
        foreach ($stats as $s): ?>
            <div class="d-flex align-items-center flex-shrink-0 mx-1 mx-md-3">
                <div class="symbol symbol-35px symbol-md-45px symbol-lg-50px me-2 me-md-3">
                    <div class="symbol-label" style="background-color:rgb(36,54,82);">
                        <i class="<?= $s['icon'] ?> text-white fs-3 fs-md-2x fs-lg-2hx"></i>
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row align-items-baseline gap-1 gap-md-2">
                    <div class="fs-3 fs-md-2hx fw-bold text-white"><?= $s['value'] ?></div>
                    <div class="fs-8 fs-md-6 fw-bold text-gray-300 text-nowrap"><?= $s['label'] ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
<?= $this->endSection() ?>

<!-- ============================================================
     CONTENT
============================================================ -->
<?= $this->section('content') ?>

<!-- ——— LOWONGAN TERBARU ——— -->
<div class="mb-n10 mb-lg-n20 z-index-2 pt-20">
    <div class="container">

        <div class="text-center mb-17">
            <span class="badge badge-lg badge-light-primary mb-5">
                <i class="bi bi-briefcase-fill me-2"></i>Lowongan Terbaru
            </span>
            <h3 class="fs-2hx text-dark fw-bolder mb-5">Temukan Karir Impian Anda</h3>
            <div class="fs-5 text-gray-600 fw-semibold">Ratusan peluang kerja menanti dari perusahaan terpercaya</div>
        </div>

        <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
            <?php if (!empty($lowongans)): ?>
                <?php foreach ($lowongans as $lw): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-elevate-up"
                            style="border-radius:.75rem;border:1px solid #e4e6ef;">
                            <div class="card-body d-flex flex-column p-8">

                                <!-- Header: logo + jenis pekerjaan -->
                                <div class="d-flex align-items-start justify-content-between mb-5">
                                    <div class="symbol symbol-60px">
                                        <?php if (!empty($lw['logo'])): ?>
                                            <span class="symbol-label bg-light-primary">
                                                <img src="<?= base_url('uploads/logo/' . $lw['logo']) ?>"
                                                    alt="logo" class="w-100 h-100"
                                                    style="object-fit:contain;padding:8px;" />
                                            </span>
                                        <?php else: ?>
                                            <span class="symbol-label bg-light-primary text-primary fs-2 fw-bold">
                                                <?= strtoupper(substr($lw['nama_perusahaan'] ?? 'P', 0, 2)) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($lw['jenis_pekerjaan'])): ?>
                                        <span class="badge badge-light-info fw-bold">
                                            <?= esc($lw['jenis_pekerjaan']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Posisi (field: posisi, bukan judul) -->
                                <a href="<?= site_url('lowongan/' . $lw['id']) ?>"
                                    class="text-gray-900 text-hover-primary fs-4 fw-bold mb-2 text-decoration-none">
                                    <?= esc($lw['posisi']) ?>
                                </a>

                                <!-- Nama Perusahaan -->
                                <div class="text-gray-600 fw-semibold fs-6 mb-5">
                                    <i class="bi bi-building me-2 text-primary"></i>
                                    <?= esc($lw['nama_perusahaan'] ?? '-') ?>
                                </div>

                                <div class="separator separator-dashed my-4"></div>

                                <!-- Info detail -->
                                <div class="d-flex flex-column gap-3 mb-7 fs-7 fw-semibold text-gray-700">

                                    <!-- Lokasi kerja (field: lokasi_kerja) -->
                                    <?php if (!empty($lw['lokasi_kerja'])): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-geo-alt text-gray-500 fs-5 me-3"></i>
                                            <?= esc($lw['lokasi_kerja']) ?>
                                        </div>
                                    <?php elseif (!empty($lw['kota'])): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-geo-alt text-gray-500 fs-5 me-3"></i>
                                            <?= esc($lw['kota']) ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Batas lamaran (field: batas_lamaran) -->
                                    <?php if (!empty($lw['batas_lamaran'])): ?>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-clock text-gray-500 fs-5"></i>
                                            Batas: <?= deadlineBadge($lw['batas_lamaran']) ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <!-- CTA -->
                                <div class="mt-auto">
                                    <a href="<?= site_url('lowongan/' . $lw['id']) ?>"
                                        class="btn btn-primary w-100">
                                        <i class="bi bi-arrow-right-circle me-2"></i>Lihat Detail
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-20">
                            <i class="bi bi-inbox fs-5x text-gray-400 mb-5 d-block"></i>
                            <h3 class="fs-2 fw-bold text-gray-800 mb-3">Belum Ada Lowongan</h3>
                            <p class="fs-5 text-gray-600 mb-5">Pantau terus untuk update lowongan terbaru!</p>
                            <a href="<?= site_url('register') ?>" class="btn btn-primary">
                                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center">
            <a href="<?= site_url('lowongan') ?>" class="btn btn-lg btn-primary">
                <i class="bi bi-grid-3x3-gap me-2"></i>Lihat Semua Lowongan
            </a>
        </div>

    </div>
</div>
<!-- ——— END LOWONGAN ——— -->

<!-- ——— PERUSAHAAN TERPERCAYA ——— -->
<div class="pt-20 pt-lg-40">
    <div class="pb-15 pt-18 bg-white">
        <div class="container">

            <div class="text-center mt-15 mb-18">
                <span class="badge badge-lg badge-light-success mb-5">
                    <i class="bi bi-buildings-fill me-2"></i>Perusahaan Terpercaya
                </span>
                <h3 class="fs-2hx text-dark fw-bolder mb-5">Perusahaan Terpercaya</h3>
                <div class="fs-5 text-gray-600 fw-semibold">
                    Bekerja sama dengan perusahaan-perusahaan terbaik di Indonesia
                </div>
            </div>

            <div class="row g-6 g-xl-9 mb-20">
                <?php if (!empty($perusahaans)): ?>
                    <?php foreach ($perusahaans as $pr): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm hover-elevate-up"
                                style="border-radius:.75rem;border:1px solid #e4e6ef;">
                                <div class="card-body d-flex flex-column p-8">

                                    <!-- Logo + Nama -->
                                    <div class="d-flex align-items-center mb-6">
                                        <?php if (!empty($pr['logo'])): ?>
                                            <div class="symbol symbol-70px me-4">
                                                <span class="symbol-label bg-light-primary">
                                                    <img src="<?= base_url('uploads/logo/' . $pr['logo']) ?>"
                                                        alt="<?= esc($pr['nama_perusahaan']) ?>"
                                                        class="w-100 h-100"
                                                        style="object-fit:contain;padding:8px;" />
                                                </span>
                                            </div>
                                        <?php else: ?>
                                            <div class="symbol symbol-70px me-4">
                                                <div class="symbol-label bg-light-primary">
                                                    <span class="fs-2x fw-bold text-primary">
                                                        <?= strtoupper(substr($pr['nama_perusahaan'], 0, 2)) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="flex-grow-1">
                                            <span class="text-gray-900 fs-5 fw-bold d-block">
                                                <?= esc($pr['nama_perusahaan']) ?>
                                            </span>
                                            <!-- bidang_usaha (field tambahan di tb_perusahaan) -->
                                            <?php if (!empty($pr['bidang_usaha'])): ?>
                                                <span class="text-gray-500 fs-7 fw-semibold">
                                                    <?= esc($pr['bidang_usaha']) ?>
                                                </span>
                                            <?php endif; ?>
                                            <div class="d-flex gap-2 mt-2 flex-wrap">
                                                <span class="badge badge-light-primary">Partner</span>
                                                <?php if (!empty($pr['total_lowongan']) && $pr['total_lowongan'] > 0): ?>
                                                    <span class="badge badge-light-success">
                                                        <?= $pr['total_lowongan'] ?> lowongan aktif
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="separator separator-dashed mb-5"></div>

                                    <!-- Kota (field: kota di tb_perusahaan) -->
                                    <?php if (!empty($pr['kota'])): ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                                            <span class="text-gray-700 fw-semibold fs-6"><?= esc($pr['kota']) ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Alamat -->
                                    <?php if (!empty($pr['alamat'])): ?>
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-map text-gray-400 me-3 fs-5 mt-1"></i>
                                            <span class="text-gray-500 fw-semibold fs-7">
                                                <?= esc(substr($pr['alamat'], 0, 60)) . (strlen($pr['alamat']) > 60 ? '...' : '') ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body text-center py-20">
                                <i class="bi bi-building fs-5x text-gray-400 mb-5 d-block"></i>
                                <h3 class="fs-2 fw-bold text-gray-800 mb-3">Belum Ada Perusahaan</h3>
                                <p class="fs-5 text-gray-600 mb-0">Hubungi kami untuk menjadi mitra perusahaan.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
<!-- ——— END PERUSAHAAN ——— -->

<!-- ——— KEUNGGULAN (seksi baru) ——— -->
<div class="py-20 bg-light">
    <div class="container">
        <div class="text-center mb-16">
            <span class="badge badge-lg badge-light-warning mb-5">
                <i class="bi bi-star-fill me-2"></i>Mengapa BKK Kami?
            </span>
            <h3 class="fs-2hx text-dark fw-bolder mb-5">Keunggulan Platform</h3>
        </div>
        <div class="row g-8">
            <?php
            $keunggulan = [
                [
                    'icon' => 'bi bi-lightning-charge-fill text-warning',
                    'bg' => 'bg-light-warning',
                    'judul' => 'Proses Cepat',
                    'desc'  => 'Lamaran diproses langsung oleh admin BKK dan perusahaan mitra tanpa birokrasi panjang.'
                ],
                [
                    'icon' => 'fas fa-check-circle text-success',
                    'bg' => 'bg-light-success',
                    'judul' => 'Perusahaan Terverifikasi',
                    'desc'  => 'Semua perusahaan mitra telah melalui proses verifikasi oleh tim BKK sekolah.'
                ],
                [
                    'icon' => 'fas fa-user-graduate text-primary',
                    'bg' => 'bg-light-primary',
                    'judul' => 'Tracer Karir Alumni',
                    'desc'  => 'Pantau perkembangan karir alumni dan jadikan data acuan pengembangan sekolah.'
                ],
                [
                    'icon' => 'bi bi-telephone-fill text-danger',
                    'bg' => 'bg-light-danger',
                    'judul' => 'Dukungan Langsung',
                    'desc'  => 'Tim BKK siap membantu proses lamaran dan konsultasi karir secara langsung.'
                ],
            ];
            foreach ($keunggulan as $k): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hover-elevate-up" style="border-radius:.75rem;">
                        <div class="card-body p-8 text-center">
                            <div class="<?= $k['bg'] ?> rounded-circle d-inline-flex align-items-center justify-content-center mb-5"
                                style="width:64px;height:64px;">
                                <i class="<?= $k['icon'] ?> fs-2x"></i>
                            </div>
                            <h4 class="fw-bold fs-4 mb-3"><?= $k['judul'] ?></h4>
                            <p class="text-gray-600 fs-6 mb-0"><?= $k['desc'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- ——— END KEUNGGULAN ——— -->

<!-- ——— KONTAK ——— -->
<div class="mt-sm-n10" id="kontak">
    <div class="landing-curve landing-dark-color">
        <svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z" fill="currentColor"></path>
        </svg>
    </div>
    <div class="py-10 landing-dark-bg">
        <div class="container">
            <div class="text-center mb-12">
                <h3 class="fs-2hx text-white fw-bold mb-5">Hubungi Kami</h3>
                <div class="fs-5 text-gray-400 fw-semibold">
                    Siap membantu mengoptimalkan sistem tracer alumni untuk sekolah dan perusahaan Anda
                </div>
            </div>
            <div class="row g-10">
                <div class="col-lg-6">
                    <div class="mb-8">
                        <h4 class="text-white fw-bold mb-2">Alamat</h4>
                        <div class="text-gray-400 fw-semibold fs-6 lh-lg">
                            SMK Teratai Putih Global 4<br />
                            Jl. Pendidikan No. 123, Kelurahan XYZ<br />
                            Jakarta Selatan 12345, Indonesia
                        </div>
                    </div>
                    <div class="mb-8">
                        <h4 class="text-white fw-bold mb-2">Email</h4>
                        <a href="mailto:bkk@smktp4.sch.id" class="text-gray-400 text-hover-primary fw-semibold fs-6">
                            bkk@smktp4.sch.id
                        </a>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-2">Telepon</h4>
                        <a href="tel:+622112345678" class="text-gray-400 text-hover-primary fw-semibold fs-6 d-block mb-1">
                            (021) 1234-5678
                        </a>
                        <div class="text-gray-500 fs-7">Senin - Jumat: 08:00 - 16:00 WIB</div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex flex-column align-items-center align-items-lg-start justify-content-center">
                    <h4 class="text-white fw-bold mb-6">Ikuti Kami</h4>
                    <div class="d-flex flex-wrap gap-4 mb-6">
                        <a href="#" class="btn btn-icon btn-transparent btn-active-color-primary" style="width:55px;height:55px;">
                            <i class="bi bi-facebook fs-2x text-gray-400"></i>
                        </a>
                        <a href="#" class="btn btn-icon btn-transparent btn-active-color-primary" style="width:55px;height:55px;">
                            <i class="bi bi-instagram fs-2x text-gray-400"></i>
                        </a>
                        <a href="#" class="btn btn-icon btn-transparent btn-active-color-primary" style="width:55px;height:55px;">
                            <i class="bi bi-twitter fs-2x text-gray-400"></i>
                        </a>
                        <a href="#" class="btn btn-icon btn-transparent btn-active-color-primary" style="width:55px;height:55px;">
                            <i class="bi bi-youtube fs-2x text-gray-400"></i>
                        </a>
                    </div>
                    <div class="text-gray-400 fs-6 fw-semibold text-center text-lg-start">
                        Dapatkan update lowongan kerja terbaru dan<br />informasi kegiatan alumni kami.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ——— END KONTAK ——— -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Typed !== 'undefined') {
            new Typed('#kt_landing_hero_text', {
                strings: [
                    'BKK &amp; Tracer Study',
                    'Perusahaan Terpercaya',
                    'Lowongan Kerja Terbaru',
                    'Tracer Alumni',
                ],
                typeSpeed: 50,
                backSpeed: 30,
                backDelay: 2000,
                loop: true,
            });
        }
    });
</script>
<?= $this->endSection() ?>