<?= $this->extend('landing/layout/app') ?>
<?= $this->section('title') ?>Edit Profil<?= $this->endSection() ?>

<?= $this->section('hero-section') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$foto = $pelamar['foto'] ?? null;
$fotoSrc = $foto ? base_url('uploads/foto/' . $foto) : base_url('assets/media/avatars/blank.png');
$isActive = $user['is_active'] ?? 0;
$isAlumni = ($user['id_role'] ?? 0) == 4;
$berkas = $berkas ?? [];
$angkatan = $angkatan ?? [];
$jurusan = $jurusan ?? [];
$aktivitas = $aktivitas ?? [];
$activeTab = session()->getFlashdata('active_tab') ?? 'tab_data_diri';

$jenisBerkas = $jenisBerkas ?? [];
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
    <div class="tab-content">
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-0 d-flex justify-content-between align-items-center flex-wrap">
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-0">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 active" data-bs-toggle="tab" href="#tab_data_diri">Data Diri</a>
                    </li>
                    <?php if ($isAlumni): ?>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#tab_tracer">Tracer Alumni</a>
                        </li>
                    <?php endif ?>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary" data-bs-toggle="tab" href="#tab_berkas">Berkas</a>
                    </li>
                </ul>
                <div class="ms-auto mt-3 mt-md-0">
                    <a href="<?= site_url('profil') ?>" class="btn btn-light-primary">
                        <i class="bi bi-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="tab-pane fade show active" id="tab_data_diri" role="tabpanel">
            <form action="<?= site_url('profil/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row g-6">
                    <div class="col-xl-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header border-0 pt-6">
                                <h3 class="card-title fw-bolder">Foto Profil</h3>
                            </div>
                            <div class="card-body d-flex flex-column align-items-center pt-4">
                                <div class="symbol symbol-150px symbol-circle mb-6">
                                    <img src="<?= $fotoSrc ?>" alt="Foto profil" style="object-fit: cover;" />
                                </div>
                                <div class="w-100 mb-5">
                                    <label class="form-label fw-semibold">Upload Foto</label>
                                    <input type="file" class="form-control form-control-solid" name="foto" accept="image/jpg,image/jpeg,image/png" />
                                    <div class="text-muted fs-7 mt-2">Format JPG atau PNG.</div>
                                </div>
                                <div class="notice bg-light-primary rounded border border-primary border-dashed p-4 w-100">
                                    <div class="fw-semibold text-gray-700 mb-1">Status akun</div>
                                    <div class="text-muted fs-7">Akun Anda saat ini <?= $isActive ? 'aktif' : 'nonaktif' ?>.</div>
                                </div>
                                <div class="w-100 mt-5">
                                    <label class="form-label fw-semibold">Status Pendaftaran</label>
                                    <?php
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
                                    <div class="form-control form-control-solid d-flex align-items-center">
                                        <span class="badge badge-light-<?= $statusPendaftaranBadge ?>">
                                            <?= esc($statusPendaftaranLabel) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card shadow-sm mb-6">
                            <div class="card-header border-bottom pt-2">
                                <h3 class="card-title fw-bolder">Informasi Pribadi</h3>
                            </div>
                            <div class="card-body pt-6">
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Lengkap</label>
                                        <input type="text" class="form-control form-control-solid" name="nama" value="<?= esc($user['nama'] ?? '') ?>" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control form-control-solid" name="email" value="<?= esc($user['email'] ?? '') ?>" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">No. Telepon</label>
                                        <input type="text" class="form-control form-control-solid" name="telepon" value="<?= esc($pelamar['telepon'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">NIK</label>
                                        <input type="text" class="form-control form-control-solid" name="nomer_nik" value="<?= esc($pelamar['nomer_nik'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                                        <select class="form-select form-select-solid" name="jenis_kelamin">
                                            <option value="">Pilih jenis kelamin</option>
                                            <option value="L" <?= ($pelamar['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="P" <?= ($pelamar['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tanggal Lahir</label>
                                        <input type="date" class="form-control form-control-solid" name="tanggal_lahir" value="<?= esc($pelamar['tanggal_lahir'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tempat Lahir</label>
                                        <input type="text" class="form-control form-control-solid" name="tempat_lahir" value="<?= esc($pelamar['tempat_lahir'] ?? '') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Password Baru</label>
                                        <input type="password" class="form-control form-control-solid" name="password" placeholder="Kosongkan jika tidak diubah" />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Alamat</label>
                                        <textarea class="form-control form-control-solid" name="alamat" rows="4"><?= esc($pelamar['alamat'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-8">
                                <i class="bi bi-check2-circle me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="tab_tracer">
            <form action="<?= site_url('profil/update-tracer') ?>" method="POST">
                <?= csrf_field() ?>
                <?php if (!$isAlumni): ?>
                    <div class="card shadow-sm">
                        <div class="card-body py-12 text-center">
                            <i class="bi bi-person-badge fs-2x text-gray-400 mb-4 d-block"></i>
                            <div class="fw-bolder text-gray-800 mb-2">Tab tracer hanya untuk akun alumni</div>
                            <div class="text-muted">Akun ini belum termasuk kategori alumni, jadi data alumni dan tracer tidak bisa diisi.</div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card shadow-sm">
                        <div class="card-header border-bottom pt-6">
                            <h3 class="card-title fw-bolder">Data Alumni & Tracer</h3>
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
                                    <div class="card  mb-4">
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
                                                    <input type="text" class="form-control form-control-solid" name="status_kuliah" value="<?= esc($tracer['status_kuliah'] ?? '') ?>" placeholder="Contoh: Semester 4" />
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
                            <i class="bi bi-save me-2"></i><?= !empty($tracer) || !empty($alumni) ? 'Update Data Tracer' : 'Simpan Data Tracer' ?>
                        </button>
                    </div>
            </form>
        <?php endif ?>
        </div>

        <div class="tab-pane fade" id="tab_berkas">
            <form action="<?= site_url('profil/upload-berkas') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="card shadow-sm">
                    <div class="card-header border-bottom pt-2">
                        <h3 class="card-title fw-bolder">Berkas Pelengkap</h3>
                    </div>
                    <div class="card-body pt-10">
                        <div class="list-group list-group-flush">
                            <?php foreach ($jenisBerkas as $key => $info): ?>
                                <?php
                                $warna = ['primary', 'warning', 'success', 'info', 'danger'][$key % 5];
                                $iconMap = [
                                    'cv' => 'bi-file-person',
                                    'surat_lamaran' => 'bi-file-earmark-text',
                                    'ijazah' => 'bi-award',
                                    'ktp' => 'bi-card-image',
                                    'skck' => 'bi-shield-check',
                                ];
                                $kode = $info['kode'] ?? '';
                                $item = $berkas[$kode] ?? null;
                                ?>

                                <div class="list-group-item p-4 mb-3">
                                    <div class="row align-items-center">

                                        <!-- KOLOM 1: ICON + LABEL -->
                                        <div class="col-md-5 d-flex align-items-center gap-3">
                                            <div class="symbol symbol-40px">
                                                <span class="symbol-label bg-light-<?= $warna ?>">
                                                    <i class="bi <?= esc($iconMap[$kode] ?? 'bi-file-earmark') ?> text-<?= $warna ?>"></i>
                                                </span>
                                            </div>

                                            <div class="d-flex align-items-center gap-2">
                                                <div class="fw-bolder"><?= esc($info['nama_berkas']) ?></div>
                                            </div>
                                        </div>

                                        <!-- KOLOM 2: STATUS -->
                                        <div class="col-md-3 text-md-center mt-3 mt-md-0">
                                            <span class="badge badge-light-<?= $item ? 'success' : 'secondary' ?>">
                                                <?= $item ? 'Sudah upload' : 'Belum upload' ?>
                                            </span>
                                        </div>

                                        <!-- KOLOM 3: AKSI -->
                                        <div class="col-md-4 d-flex justify-content-md-end align-items-center gap-2 mt-3 mt-md-0">

                                            <?php if ($item): ?>
                                                <a href="<?= base_url($item['path_file']) ?>" target="_blank" class="btn btn-sm btn-light-success">
                                                    Lihat
                                                </a>
                                            <?php endif ?>

                                            <form action="<?= site_url('profil/upload-berkas') ?>" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="id_jenis_berkas" value="<?= esc($info['id']) ?>">

                                                <input type="file" name="berkas" class="form-control form-control-sm" required>

                                                <button type="submit" class="btn btn-sm btn-<?= $warna ?>">
                                                    <?= $item ? 'Ubah' : 'Upload' ?>
                                                </button>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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

        // Mapping: kata kunci dari nama aktivitas → key section
        function getSlugFromNama(nama) {
            var lower = nama.toLowerCase();
            if (lower.includes('kerja') || lower.includes('pkl') || lower.includes('bekerja') || lower.includes('magang')) {
                return 'bekerja';
            }
            if (lower.includes('kuliah') || lower.includes('universitas') || lower.includes('perguruan')) {
                return 'kuliah';
            }
            if (lower.includes('usaha') || lower.includes('wirausaha') || lower.includes('bisnis')) {
                return 'wirausaha';
            }
            if (lower.includes('rencana')) {
                return 'berencana_kuliah';
            }
            return '';
        }

        function updateSections() {
            if (!aktivitasSelect) return;

            var selectedOption = aktivitasSelect.options[aktivitasSelect.selectedIndex];

            var slug = selectedOption ? selectedOption.getAttribute('data-slug') : '';

            Object.keys(sections).forEach(function(key) {
                var section = sections[key];
                if (section) {
                    section.style.display = 'none';

                    // 🔥 disable semua input di section
                    section.querySelectorAll('input, select, textarea').forEach(function(el) {
                        el.disabled = true;
                    });
                }
            });

            // tampilkan + enable section aktif
            if (slug && sections[slug]) {
                var activeSection = sections[slug];
                activeSection.style.display = 'block';

                activeSection.querySelectorAll('input, select, textarea').forEach(function(el) {
                    el.disabled = false;
                });
            }

            if (!slug) {
                var text = selectedOption ? selectedOption.textContent.trim().toLowerCase() : '';

                if (text === 'bekerja') slug = 'bekerja';
                else if (text === 'kuliah') slug = 'kuliah';
                else if (text === 'wirausaha') slug = 'wirausaha';
                else if (text === 'berencana kuliah') slug = 'berencana_kuliah';
                else if (text === 'mencari kerja') slug = 'mencari_kerja';
            }

            console.log('FINAL SLUG:', slug);

            // sembunyikan semua
            Object.values(sections).forEach(function(s) {
                if (s) s.style.display = 'none';
            });

            // tampilkan sesuai slug
            if (slug && sections[slug]) {
                sections[slug].style.display = 'block';
            }
        }

        if (aktivitasSelect) {
            aktivitasSelect.addEventListener('change', updateSections);
            updateSections(); // jalankan saat halaman load
        }

        // Jalankan ulang saat tab tracer dibuka
        var tracerTab = document.querySelector('a[href="#tab_tracer"]');
        if (tracerTab) {
            tracerTab.addEventListener('shown.bs.tab', function() {
                updateSections();
            });
        }

        // Aktifkan tab dari hash URL
        var hash = window.location.hash;
        if (hash) {
            var tabEl = document.querySelector('a[href="' + hash + '"]');
            if (tabEl) new bootstrap.Tab(tabEl).show();
        }

        // Aktifkan tab dari flash data
        var activeTab = '<?= $activeTab ?>';
        if (activeTab && activeTab !== 'tab_data_diri') {
            var flashTabEl = document.querySelector('a[href="#' + activeTab + '"]');
            if (flashTabEl) new bootstrap.Tab(flashTabEl).show();
        }

        // Update hash saat tab diklik
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(el) {
            el.addEventListener('shown.bs.tab', function(e) {
                history.replaceState(null, null, e.target.getAttribute('href'));
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {

        const input = document.getElementById('penghasilan');

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
