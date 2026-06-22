<?= $this->extend('admin/layout/app') ?>
<?= $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">

    <?php $logoUrl = $logoUrl ?? (!empty($lowongan['logo']) ? base_url('uploads/logo/' . $lowongan['logo']) : null); ?>

    <!-- Header Card -->
    <div class="card mb-5">
        <div class="card-header border-0 pt-5 pb-5">
            <div class="card-title">
                <h3 class="fw-bolder m-0">Detail Lowongan</h3>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editLowonganModal"
                    data-id="<?= $lowongan['id'] ?>"
                    data-id_perusahaan="<?= $lowongan['id_perusahaan'] ?>"
                    data-posisi="<?= esc($lowongan['posisi']) ?>"
                    data-gaji="<?= esc($lowongan['gaji']) ?>"
                    data-jenis_pekerjaan="<?= esc($lowongan['jenis_pekerjaan']) ?>"
                    data-lokasi_kerja="<?= esc($lowongan['lokasi_kerja'] ?? '') ?>"
                    data-batas_lamaran="<?= esc($lowongan['batas_lamaran'] ?? '') ?>"
                    data-status="<?= esc($lowongan['status']) ?>"
                    data-deskripsi="<?= esc($lowongan['deskripsi_pekerjaan'] ?? '') ?>"
                    data-kualifikasi="<?= esc($lowongan['kualifikasi'] ?? '') ?>"
                    data-jurusan='<?= esc(json_encode($lowongan['id_jurusan'] ?? [])) ?>'>
                    Edit Lowongan
                </button>
            </div>
        </div>
    </div>

    <!-- ✅ Layout: Kiri (detail + deskripsi) | Kanan (perusahaan) -->
    <div class="row g-5">

        <!-- KOLOM KIRI -->
        <div class="col-xl-8">

            <!-- Card Detail Lowongan -->
            <div class="card shadow-sm mb-5">
                <div class="card-body p-8">
                    <div class="d-flex align-items-center gap-5 mb-7">
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
                            <h2 class="text-gray-900 fw-bolder mb-1"><?= esc($lowongan['posisi'] ?? '-') ?></h2>
                            <div class="fs-6 text-gray-500 mb-3"><?= esc($lowongan['nama_perusahaan'] ?? '-') ?></div>
                            <div class="d-flex gap-2">
                                <span class="badge badge-light-info"><?= esc(ucfirst($lowongan['jenis_pekerjaan'] ?? '-')) ?></span>
                                <span class="badge <?= $lowongan['status'] === 'aktif' ? 'badge-light-success' : 'badge-light-secondary' ?>">
                                    <?= esc(ucfirst($lowongan['status'] ?? '-')) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="separator mb-7"></div>

                    <div class="row gx-5 gy-4 mb-7">
                        <div class="col-md-3">
                            <div class="fw-semibold text-gray-500 fs-7 mb-1">Batas Lamaran</div>
                            <div class="text-gray-800 fw-bold"><?= esc($lowongan['batas_lamaran'] ?? '-') ?></div>
                        </div>
                        <div class="col-md-3">
                            <div class="fw-semibold text-gray-500 fs-7 mb-1">Lokasi Kerja</div>
                            <div class="text-gray-800 fw-bold"><?= esc($lowongan['lokasi_kerja'] ?? $lowongan['kota'] ?? '-') ?></div>
                        </div>

                        <div class="col-md-3">
                            <div class="fw-semibold text-gray-500 fs-7 mb-1">Gaji</div>
                            <div class="text-gray-800 fw-bold"><?= esc($lowongan['gaji'] ?? '-') ?></div>
                        </div>
                        <div class="col-md-3">
                            <div class="fw-semibold text-gray-500 fs-7 mb-1">Bidang Usaha</div>
                            <div class="text-gray-800 fw-bold"><?= esc($lowongan['bidang_usaha'] ?? '-') ?></div>
                        </div>
                    </div>

                    <?php if (!empty($lowongan['id_jurusan'])): ?>
                        <div class="separator mb-7"></div>
                        <div class="fw-bold text-gray-800 mb-4">Jurusan yang Direkomendasikan</div>
                        <div class="row g-3">
                            <?php foreach ($lowongan['id_jurusan'] as $idJurusan):
                                $jurusanData = array_filter($jurusan, fn($j) => $j['id'] == $idJurusan);
                                if (!empty($jurusanData)):
                                    $jurusanItem = array_shift($jurusanData); ?>
                                    <div class="col-md-6">
                                        <span class="badge badge-light-primary fs-7 fw-semibold py-3 px-4 w-100 text-start">
                                            <?= esc($jurusanItem['kompetensi_keahlian']) ?>
                                        </span>
                                    </div>
                            <?php endif;
                            endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($lowongan['syarat_berkas'])): ?>
                        <div class="separator mb-7"></div>
                        <div class="fw-bold text-gray-800 mb-4">Syarat Berkas</div>
                        <div class="row g-3">
                            <?php foreach ($lowongan['syarat_berkas'] as $syarat): ?>
                                <div class="col-md-6">
                                    <span class="badge badge-light-dark fs-7 fw-semibold py-3 px-4 w-100 text-start">
                                        <?= esc($syarat['nama_berkas']) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card Deskripsi & Kualifikasi -->
            <div class="card shadow-sm">
                <div class="card-body p-8">
                    <div class="mb-8">
                        <h5 class="fw-bold text-gray-800 mb-4">Deskripsi Pekerjaan</h5>
                        <div class="fs-6 text-gray-700 lh-lg">
                            <?= nl2br(esc($lowongan['deskripsi_pekerjaan'] ?? 'Belum ada deskripsi pekerjaan.')) ?>
                        </div>
                    </div>
                    <div class="separator mb-8"></div>
                    <div>
                        <h5 class="fw-bold text-gray-800 mb-4">Kualifikasi & Persyaratan</h5>
                        <div class="fs-6 text-gray-700 lh-lg">
                            <?= nl2br(esc($lowongan['kualifikasi'] ?? 'Belum ada kualifikasi terdaftar.')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Detail Perusahaan -->
        <div class="col-xl-4">
            <div class="card shadow-sm">
                <div class="card-body p-8">
                    <div class="d-flex align-items-center gap-4 mb-7">
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
                            <div class="fs-8 text-gray-500 mb-1">Perusahaan</div>
                            <div class="fs-5 fw-bold text-gray-900"><?= esc($lowongan['nama_perusahaan'] ?? '-') ?></div>
                        </div>
                    </div>

                    <div class="separator mb-6"></div>

                    <div class="mb-5">
                        <div class="fw-semibold text-gray-500 fs-7 mb-1">Bidang Usaha</div>
                        <div class="text-gray-800"><?= esc($lowongan['bidang_usaha'] ?? '-') ?></div>
                    </div>
                    <div class="mb-5">
                        <div class="fw-semibold text-gray-500 fs-7 mb-1">Lokasi</div>
                        <div class="text-gray-800"><?= esc($lowongan['lokasi_kerja'] ?? $lowongan['kota'] ?? '-') ?></div>
                    </div>

                    <a href="<?= site_url('admin/data-lowongan') ?>" class="btn btn-light-primary w-100 fs-7">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Lowongan
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- ===== Modal Edit ===== -->
<div class="modal fade" id="editLowonganModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content rounded">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <form id="formEditLowongan" action="" method="POST"
                    data-action-template="<?= site_url('admin/data-lowongan/update/:id') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Edit Lowongan</h1>
                    </div>
                    <div class="row g-3 mb-8">
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-2"><span class="required">Perusahaan</span></label>
                                <select class="form-control form-control-solid" name="id_perusahaan" id="editIdPerusahaan" required>
                                    <option value="">-- Pilih Perusahaan --</option>
                                    <?php foreach ($perusahaan as $p): ?>
                                        <option value="<?= $p['id'] ?>"><?= esc($p['nama_perusahaan']) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-2"><span class="required">Posisi</span></label>
                                <input type="text" class="form-control form-control-solid" name="posisi" id="editPosisi" required />
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-2"><span class="required">Gaji</span></label>
                                <input type="text" class="form-control form-control-solid" name="gaji" id="editGaji" required />
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-2"><span class="required">Jenis Pekerjaan</span></label>
                                <select class="form-control form-control-solid" name="jenis_pekerjaan" id="editJenisPekerjaan" required>
                                    <option value="fulltime">Full Time</option>
                                    <option value="parttime">Part Time</option>
                                    <option value="magang">Magang</option>
                                    <option value="kontrak">Kontrak</option>
                                </select>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Lokasi Kerja</label>
                                <input type="text" class="form-control form-control-solid" name="lokasi_kerja" id="editLokasiKerja" />
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-2"><span class="required">Batas Lamaran</span></label>
                                <input type="date" class="form-control form-control-solid" name="batas_lamaran" id="editBatasLamaran" required />
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-2"><span class="required">Status</span></label>
                                <select class="form-control form-control-solid" name="status" id="editStatus" required>
                                    <option value="draft">Draft</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="ditutup">Ditutup</option>
                                    <option value="kadaluarsa">Kadaluarsa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Deskripsi Pekerjaan</label>
                                <textarea class="form-control form-control-solid" name="deskripsi_pekerjaan" id="editDeskripsi" rows="3"></textarea>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Kualifikasi</label>
                                <textarea class="form-control form-control-solid" name="kualifikasi" id="editKualifikasi" rows="3"></textarea>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-3">Jurusan / Keahlian</label>
                                <div class="d-flex flex-column gap-2">
                                    <?php foreach ($jurusan as $j): ?>
                                        <label class="d-flex align-items-center gap-2 cursor-pointer">
                                            <input type="checkbox" class="form-check-input edit-jurusan-cb" name="jurusan[]" value="<?= $j['id'] ?>" />
                                            <span class="fs-6 fw-semibold text-gray-700">
                                                <?= esc($j['kompetensi_keahlian']) ?>
                                                <?php if ($j['akronim']): ?>
                                                    <span class="text-muted">(<?= esc($j['akronim']) ?>)</span>
                                                <?php endif ?>
                                            </span>
                                        </label>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="fs-6 fw-semibold mb-3">Syarat Berkas</label>
                                <div class="d-flex flex-column gap-2">
                                    <?php foreach ($jenisBerkas as $jb): ?>
                                        <label class="d-flex align-items-center gap-2 cursor-pointer">
                                            <input type="checkbox" class="form-check-input edit-berkas-cb" name="jenis_berkas[]" value="<?= $jb['id'] ?>" />
                                            <span class="fs-6 fw-semibold text-gray-700"><?= esc($jb['nama_berkas']) ?></span>
                                        </label>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ===== /Modal Edit ===== -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).on('click', '[data-bs-target="#editLowonganModal"]', function() {
        const btn = $(this);
        const form = $('#formEditLowongan');

        $('#editIdPerusahaan').val(btn.data('id_perusahaan'));
        $('#editPosisi').val(btn.data('posisi'));
        $('#editGaji').val(btn.data('gaji'));
        $('#editJenisPekerjaan').val(btn.data('jenis_pekerjaan'));
        $('#editLokasiKerja').val(btn.data('lokasi_kerja'));
        $('#editBatasLamaran').val(btn.data('batas_lamaran'));
        $('#editStatus').val(btn.data('status'));
        $('#editDeskripsi').val(btn.data('deskripsi'));
        $('#editKualifikasi').val(btn.data('kualifikasi'));

        const selectedJurusan = btn.data('jurusan') || [];
        $('.edit-jurusan-cb').each(function() {
            $(this).prop('checked', selectedJurusan.includes(parseInt($(this).val())));
        });

        const actionTemplate = form.data('action-template');
        form.attr('action', actionTemplate.replace(':id', btn.data('id')));
    });
    document.addEventListener('DOMContentLoaded', function() {

        const input = document.getElementById('editGaji');
        if (!input) return;

        function formatRupiah(angka) {
            // ambil hanya angka
            let number_string = angka.replace(/[^,\d]/g, '').toString();

            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah ? 'Rp ' + rupiah : '';
        }

        input.addEventListener('input', function(e) {
            input.value = formatRupiah(this.value);
        });

    });
</script>
<?= $this->endSection() ?>