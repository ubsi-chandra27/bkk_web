<?= $this->extend('landing/layout/app') ?>

<?= $this->section('hero-section') ?>
<div class="d-flex flex-column flex-center w-100 min-h-100px min-h-lg-200px px-9 text-center">
    <h1 class="text-white fw-bolder fs-2hx mb-3">Lowongan Kerja</h1>
    <p class="text-white fw-semibold fs-5 opacity-75 mb-0">
        Temukan peluang karir terbaik untuk Anda
    </p>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-12">

    <!-- ===== Search Bar (Metronic client-side) ===== -->
    <div class="card shadow-sm mb-8">
        <div class="card-body p-5">
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative flex-grow-1">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y ms-4 fs-3 text-gray-500"></i>
                    <input type="text"
                        class="form-control form-control-lg ps-14"
                        placeholder="Cari posisi, lokasi, atau nama perusahaan..."
                        data-kt-search-element="input">
                </div>
                <button class="btn btn-icon btn-light d-none" data-kt-search-element="clear"
                    title="Hapus pencarian">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>
            </div>
            <div class="mt-3 d-none" data-kt-search-element="info">
                <span class="text-gray-600 fs-7">
                    Menampilkan <strong data-kt-search-element="count">0</strong> lowongan
                </span>
            </div>
        </div>
    </div>

    <!-- ===== Empty state ===== -->
    <div class="d-none text-center py-20" data-kt-search-element="empty">
        <i class="bi bi-briefcase-slash fs-5x text-gray-400 mb-5 d-block"></i>
        <h3 class="fs-2 fw-bold text-gray-800 mb-3">Lowongan Tidak Ditemukan</h3>
        <p class="fs-5 text-gray-600 mb-5">Coba kata kunci lain, misalnya nama posisi atau nama perusahaan.</p>
        <button class="btn btn-light-primary" onclick="
            document.querySelector('[data-kt-search-element=input]').value = '';
            document.querySelector('[data-kt-search-element=input]').dispatchEvent(new Event('input'));
        ">
            <i class="bi bi-arrow-counterclockwise me-2"></i>Tampilkan Semua
        </button>
    </div>

    <!-- ===== Grid Lowongan ===== -->
    <div class="row g-6">
        <?php if (!empty($lowongans)): ?>
            <?php foreach ($lowongans as $lw): ?>
                <div class="col-md-6 col-xl-4" data-kt-search-element="item">
                    <div class="card h-100 shadow-sm hover-elevate-up"
                        style="border-radius:.75rem;border:1px solid #e4e6ef;">
                        <div class="card-body p-8 d-flex flex-column">

                            <!-- Header: logo + badge jenis pekerjaan -->
                            <div class="d-flex align-items-start justify-content-between mb-5">
                                <div class="symbol symbol-60px">
                                    <?php if (!empty($lw['logo'])): ?>
                                        <span class="symbol-label bg-light-primary">
                                            <img src="<?= base_url('uploads/' . $lw['logo']) ?>"
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
                                    <!--
                                jenis_pekerjaan juga bisa dicari karena ada di data-kt-search-element="text"
                                di bawah, tapi badge ini hanya visual
                            -->
                                    <span class="badge badge-light-info fw-bold">
                                        <?= esc($lw['jenis_pekerjaan']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Posisi → title (teks utama pencarian) -->
                            <a href="<?= site_url('lowongan/' . $lw['id']) ?>"
                                class="text-gray-900 text-hover-primary fs-4 fw-bold mb-2 text-decoration-none"
                                data-kt-search-element="title">
                                <?= esc($lw['posisi']) ?>
                            </a>

                            <!-- Nama perusahaan → text (ikut dicari) -->
                            <div class="text-gray-500 fw-semibold fs-6 mb-5">
                                <i class="bi bi-building me-1 text-primary"></i>
                                <span data-kt-search-element="text">
                                    <?= esc($lw['nama_perusahaan'] ?? '-') ?>
                                </span>
                            </div>

                            <div class="separator separator-dashed mb-5"></div>

                            <div class="d-flex flex-column gap-2 mb-7 fs-7 text-gray-700 fw-semibold">

                                <!-- lokasi_kerja → text (ikut dicari) -->
                                <?php $lokasi = $lw['lokasi_kerja'] ?? $lw['kota'] ?? ''; ?>
                                <?php if (!empty($lokasi)): ?>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-geo-alt me-2 text-gray-500"></i>
                                        <span data-kt-search-element="text"><?= esc($lokasi) ?></span>
                                    </div>
                                <?php endif; ?>

                                <!-- jenis_pekerjaan → text (ikut dicari, tapi hidden secara visual) -->
                                <?php if (!empty($lw['jenis_pekerjaan'])): ?>
                                    <span class="d-none" data-kt-search-element="text">
                                        <?= esc($lw['jenis_pekerjaan']) ?>
                                    </span>
                                <?php endif; ?>

                                <!-- batas_lamaran dengan badge warna -->
                                <?php if (!empty($lw['batas_lamaran'])): ?>
                                    <?php
                                    $diff  = (int) ceil((strtotime($lw['batas_lamaran']) - time()) / 86400);
                                    $cls   = $diff < 0 ? 'badge-light-danger' : ($diff <= 7 ? 'badge-light-warning' : 'badge-light-success');
                                    $label = $diff < 0 ? 'Ditutup' : ($diff === 0 ? 'Hari ini' : ($diff <= 7 ? $diff . ' hari lagi' : date('d M Y', strtotime($lw['batas_lamaran']))));
                                    ?>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-clock text-gray-500"></i>
                                        Batas: <span class="badge <?= $cls ?> fw-bold"><?= $label ?></span>
                                    </div>
                                <?php endif; ?>

                            </div>

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

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    "use strict";

    var LowonganSearch = function() {
        var input, countElement, clearBtn, items, emptyElement;

        var search = function() {
            var searchTerm = input.value.toLowerCase().trim();
            var visibleCount = 0;
            var infoElement = document.querySelector('[data-kt-search-element="info"]');

            items.forEach(function(item) {
                var title = item.querySelector('[data-kt-search-element="title"]');
                var texts = item.querySelectorAll('[data-kt-search-element="text"]');

                var searchableText = title ? title.innerText.toLowerCase() : '';
                texts.forEach(function(t) {
                    searchableText += ' ' + t.innerText.toLowerCase();
                });

                var isMatch = searchTerm === '' || searchableText.includes(searchTerm);
                item.classList.toggle('d-none', !isMatch);
                if (isMatch) visibleCount++;
            });

            if (countElement) countElement.textContent = visibleCount;
            if (emptyElement) emptyElement.classList.toggle('d-none', !(visibleCount === 0 && searchTerm !== ''));
            if (infoElement) infoElement.classList.toggle('d-none', searchTerm === '');
            if (clearBtn) clearBtn.classList.toggle('d-none', searchTerm === '');
        };

        var clear = function() {
            input.value = '';
            search();
            input.focus();
        };

        return {
            init: function() {
                input = document.querySelector('[data-kt-search-element="input"]');
                countElement = document.querySelector('[data-kt-search-element="count"]');
                clearBtn = document.querySelector('[data-kt-search-element="clear"]');
                items = document.querySelectorAll('[data-kt-search-element="item"]');
                emptyElement = document.querySelector('[data-kt-search-element="empty"]');

                if (input) input.addEventListener('input', search);
                if (clearBtn) clearBtn.addEventListener('click', clear);
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        LowonganSearch.init();
    });
</script>
<?= $this->endSection() ?>