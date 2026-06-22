<?= $this->extend('landing/layout/app') ?>

<?= $this->section('hero-section') ?>
<div class="d-flex flex-column flex-center w-100 min-h-200px min-h-lg-300px px-9 text-center">
    <h1 class="text-white fw-bolder fs-2hx mb-3">Perusahaan Mitra</h1>
    <p class="text-white fw-semibold fs-5 opacity-75 mb-0">
        Jelajahi perusahaan-perusahaan yang telah bermitra dengan kami
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
                        placeholder="Cari perusahaan berdasarkan nama, kota, atau bidang usaha..."
                        data-kt-search-element="input">
                </div>
                <button class="btn btn-icon btn-light d-none" data-kt-search-element="clear"
                    title="Hapus pencarian">
                    <i class="bi bi-x-lg fs-4"></i>
                </button>
            </div>
            <!-- Info jumlah hasil — tersembunyi saat belum mengetik -->
            <div class="mt-3 d-none" data-kt-search-element="info">
                <span class="text-gray-600 fs-7">
                    Menampilkan <strong data-kt-search-element="count">0</strong> perusahaan
                </span>
            </div>
        </div>
    </div>

    <!-- ===== Empty state ===== -->
    <div class="d-none text-center py-20" data-kt-search-element="empty">
        <i class="bi bi-building-slash fs-5x text-gray-400 mb-5 d-block"></i>
        <h3 class="fs-2 fw-bold text-gray-800 mb-3">Perusahaan Tidak Ditemukan</h3>
        <p class="fs-5 text-gray-600 mb-0">Coba kata kunci lain atau hubungi kami untuk informasi lebih lanjut.</p>
    </div>

    <!-- ===== Grid Perusahaan ===== -->
    <div class="row g-6">
        <?php if (!empty($perusahaans)): ?>
            <?php foreach ($perusahaans as $pr): ?>
                <!--
                Setiap col diberi data-kt-search-element="item"
                Teks yang ingin dicari: "title" (utama) dan "text" (sekunder)
            -->
                <div class="col-md-6 col-lg-4" data-kt-search-element="item">
                    <div class="card h-100 shadow-sm hover-elevate-up"
                        style="border-radius:.75rem;border:1px solid #e4e6ef;">
                        <div class="card-body p-8 d-flex flex-column">

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
                                    <!-- title → teks utama yang dicari -->
                                    <span class="text-gray-900 fs-5 fw-bold d-block"
                                        data-kt-search-element="title">
                                        <?= esc($pr['nama_perusahaan']) ?>
                                    </span>
                                    <?php if (!empty($pr['bidang_usaha'])): ?>
                                        <!-- text → teks sekunder yang ikut dicari -->
                                        <span class="text-gray-500 fs-7 d-block mt-1"
                                            data-kt-search-element="text">
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

                            <?php if (!empty($pr['kota'])): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                                    <!-- kota juga ikut dicari -->
                                    <span class="text-gray-700 fw-semibold fs-6"
                                        data-kt-search-element="text">
                                        <?= esc($pr['kota']) ?>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    "use strict";

    var PerusahaanSearch = function() {
        var input, countElement, clearBtn, items, emptyElement;

        var search = function() {
            var searchTerm = input.value.toLowerCase().trim();
            var visibleCount = 0;
            var infoElement = document.querySelector('[data-kt-search-element="info"]');

            items.forEach(function(item) {
                var title = item.querySelector('[data-kt-search-element="title"]');
                var texts = item.querySelectorAll('[data-kt-search-element="text"]');

                // Gabungkan semua teks yang bisa dicari dalam satu item
                var searchableText = title ? title.innerText.toLowerCase() : '';
                texts.forEach(function(t) {
                    searchableText += ' ' + t.innerText.toLowerCase();
                });

                var isMatch = searchableText.includes(searchTerm);
                item.classList.toggle('d-none', !isMatch);
                if (isMatch) visibleCount++;
            });

            if (countElement) countElement.textContent = visibleCount;

            // Tampilkan empty state hanya jika ada keyword tapi 0 hasil
            if (emptyElement) emptyElement.classList.toggle('d-none', !(visibleCount === 0 && searchTerm !== ''));

            // Tampilkan info count & tombol clear hanya saat ada keyword
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
        PerusahaanSearch.init();
    });
</script>
<?= $this->endSection() ?>