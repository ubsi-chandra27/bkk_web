<?= $this->extend('landing/layout/app') ?>
<?= $this->section('title') ?>Form Tracer Study<?= $this->endSection() ?>

<?= $this->section('hero-section') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$angkatan = $angkatan ?? [];
$jurusan = $jurusan ?? [];
$aktivitas = $aktivitas ?? [];
$alumni = $alumni ?? [];
$tracer = $tracer ?? [];
?>

<div class="container py-10">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible mb-6">
            <i class="bi bi-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible mb-6">
            <i class="bi bi-exclamation-circle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <?php if (!empty($tracer)): ?>
        <div class="alert alert-info mb-6">
            <i class="bi bi-info-circle me-2"></i>Data sudah pernah diisi, Anda sedang memperbarui data.
        </div>
    <?php endif ?>

    <form action="<?= site_url('tracer-study/save') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="card shadow-sm">
            <div class="card-header border-bottom pt-6">
                <div>
                    <h3 class="card-title fw-bolder mb-1">Form Tracer Study</h3>
                    <div class="text-muted fw-semibold">Isi data berikut untuk melengkapi data tracer alumni kamu.</div>
                </div>
            </div>
            <div class="card-body pt-10">
                <div class="row g-5">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Angkatan</label>
                        <select class="form-select form-select-solid" name="id_angkatan" required>
                            <option value="">Pilih angkatan</option>
                            <?php foreach ($angkatan as $item): ?>
                                <option value="<?= esc($item['id']) ?>" <?= (string) ($alumni['id_angkatan'] ?? '') === (string) $item['id'] ? 'selected' : '' ?>>
                                    <?= esc($item['tahun']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jurusan</label>
                        <select class="form-select form-select-solid" name="id_jurusan" required>
                            <option value="">Pilih jurusan</option>
                            <?php foreach ($jurusan as $item): ?>
                                <option value="<?= esc($item['id']) ?>" <?= (string) ($alumni['id_jurusan'] ?? '') === (string) $item['id'] ? 'selected' : '' ?>>
                                    <?= esc($item['kompetensi_keahlian']) ?><?= !empty($item['akronim']) ? ' (' . esc($item['akronim']) . ')' : '' ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NIS</label>
                        <input type="text" class="form-control form-control-solid" name="nis" value="<?= esc($alumni['nis'] ?? '') ?>" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NISN</label>
                        <input type="text" class="form-control form-control-solid" name="nisn" value="<?= esc($alumni['nisn'] ?? '') ?>" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. Ijazah</label>
                        <input type="text" class="form-control form-control-solid" name="no_ijazah" value="<?= esc($alumni['no_ijazah'] ?? '') ?>" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Aktivitas</label>
                        <select class="form-select form-select-solid" name="id_aktivitas" id="aktivitasSelect" required>
                            <option value="">Pilih aktivitas</option>
                            <?php foreach ($aktivitas as $item): ?>
                                <option value="<?= esc($item['id']) ?>"
                                    <?= (string) ($tracer['id_aktivitas'] ?? '') === (string) $item['id'] ? 'selected' : '' ?>
                                    data-slug="<?= esc(strtolower(str_replace(' ', '_', trim($item['nama_aktivitas'])))) ?>">
                                    <?= esc($item['nama_aktivitas']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="col-12" id="section_bekerja" style="display: none;">
                        <div class="card mb-4">
                            <div class="card-body border border-dashed border-gray-300 rounded-3">
                                <h6 class="fw-bolder text-primary mb-4 pb-6 border-bottom">Informasi Pekerjaan</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama DU/DI / Instansi</label>
                                        <input type="text" class="form-control form-control-solid" name="nama_dudi" value="<?= esc($tracer['nama_dudi'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Posisi Kerja</label>
                                        <input type="text" class="form-control form-control-solid" name="posisi_kerja" value="<?= esc($tracer['posisi_kerja'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Bidang DU/DI</label>
                                        <input type="text" class="form-control form-control-solid" name="bidang_dudi" value="<?= esc($tracer['bidang_dudi'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tahun Mulai Kerja</label>
                                        <input type="number" min="2000" max="2100" class="form-control form-control-solid" name="tahun_mulai_kerja" value="<?= esc($tracer['tahun_mulai_kerja'] ?? '') ?>" />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Alamat DU/DI</label>
                                        <textarea class="form-control form-control-solid" name="alamat_dudi" rows="3"><?= esc($tracer['alamat_dudi'] ?? '') ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Relevan dengan Jurusan</label>
                                        <select class="form-select form-select-solid" name="is_relevan_jurusan">
                                            <option value="">Pilih</option>
                                            <option value="1" <?= (string) ($tracer['is_relevan_jurusan'] ?? '') === '1' ? 'selected' : '' ?>>Ya</option>
                                            <option value="0" <?= (string) ($tracer['is_relevan_jurusan'] ?? '') === '0' ? 'selected' : '' ?>>Tidak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Range Penghasilan Kerja</label>
                                        <input type="text" class="form-control form-control-solid" name="penghasilan_range" id="penghasilan" value="<?= esc($tracer['penghasilan_range'] ?? '') ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" id="section_kuliah" style="display: none;">
                        <div class="card mb-4">
                            <div class="card-body border border-dashed border-gray-300 rounded-3">
                                <h6 class="fw-bolder text-primary mb-4 pb-6 border-bottom">Informasi Kuliah</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Universitas</label>
                                        <input type="text" class="form-control form-control-solid" name="universitas" value="<?= esc($tracer['universitas'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Program Studi</label>
                                        <input type="text" class="form-control form-control-solid" name="program_studi" value="<?= esc($tracer['program_studi'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Status Kuliah</label>
                                        <input type="text" class="form-control form-control-solid" name="status_kuliah" value="<?= esc($tracer['status_kuliah'] ?? '') ?>" placeholder="Contoh: D3/D4/S1/S2.." />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" id="section_wirausaha" style="display: none;">
                        <div class="card mb-4">
                            <div class="card-body border border-dashed border-gray-300 rounded-3">
                                <h6 class="fw-bolder text-primary mb-4 pb-6 border-bottom">Informasi Usaha</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Usaha</label>
                                        <input type="text" class="form-control form-control-solid" name="nama_usaha" value="<?= esc($tracer['nama_usaha'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Bidang Usaha</label>
                                        <input type="text" class="form-control form-control-solid" name="bidang_usaha" value="<?= esc($tracer['bidang_usaha'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Modal Awal</label>
                                        <input type="text" class="form-control form-control-solid" name="modal_awal" value="<?= esc($tracer['modal_awal'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Penghasilan Usaha</label>
                                        <input type="text" class="form-control form-control-solid" name="penghasilan_usaha" value="<?= esc($tracer['penghasilan_usaha'] ?? '') ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" id="section_berencana_kuliah" style="display: none;">
                        <div class="card mb-4">
                            <div class="card-body border border-dashed border-gray-300 rounded-3">
                                <h6 class="fw-bolder text-primary mb-4 border-bottom pb-6">Rencana Kuliah</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Rencana Universitas</label>
                                        <input type="text" class="form-control form-control-solid" name="rencana_universitas" value="<?= esc($tracer['rencana_universitas'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Rencana Program Studi</label>
                                        <input type="text" class="form-control form-control-solid" name="rencana_prodi" value="<?= esc($tracer['rencana_prodi'] ?? '') ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" id="section_mencari_kerja" style="display: none;">
                        <div class="card mb-4">
                            <div class="card-body border border-dashed border-gray-300 rounded-3">
                                <h6 class="fw-bolder text-primary mb-4">Mencari Kerja</h6>
                                <p class="text-muted">Alumni sedang mencari pekerjaan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-6">
            <button type="submit" class="btn btn-primary px-8">
                <i class="bi bi-save me-2"></i><?= !empty($tracer) ? 'Update Data Tracer' : 'Simpan Data Tracer' ?>
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var aktivitasSelect = document.getElementById('aktivitasSelect');

        var sections = {
            bekerja: document.getElementById('section_bekerja'),
            kuliah: document.getElementById('section_kuliah'),
            wirausaha: document.getElementById('section_wirausaha'),
            berencana_kuliah: document.getElementById('section_berencana_kuliah'),
            mencari_kerja: document.getElementById('section_mencari_kerja')
        };

        function updateSections() {
            if (!aktivitasSelect) return;

            var selectedOption = aktivitasSelect.options[aktivitasSelect.selectedIndex];
            var slug = selectedOption ? selectedOption.getAttribute('data-slug') : '';

            if (!slug) {
                var text = selectedOption ? selectedOption.textContent.trim().toLowerCase() : '';

                if (text === 'bekerja') slug = 'bekerja';
                else if (text === 'kuliah') slug = 'kuliah';
                else if (text === 'wirausaha') slug = 'wirausaha';
                else if (text === 'berencana kuliah') slug = 'berencana_kuliah';
                else if (text === 'mencari kerja') slug = 'mencari_kerja';
            }

            Object.keys(sections).forEach(function(key) {
                var section = sections[key];
                if (!section) return;

                var isActive = slug && key === slug;
                section.style.display = isActive ? 'block' : 'none';
                section.querySelectorAll('input, select, textarea').forEach(function(el) {
                    el.disabled = !isActive;
                });
            });
        }

        if (aktivitasSelect) {
            aktivitasSelect.addEventListener('change', updateSections);
            updateSections();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('penghasilan');

        if (!input) return;

        function formatRupiah(angka) {
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

        input.addEventListener('input', function() {
            input.value = formatRupiah(this.value);
        });
    });
</script>
<?= $this->endSection() ?>
