<?= $this->extend('admin/layout/app') ?>
<?= $this->section('content') ?>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible mb-6">
                <i class="bi bi-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger mb-4">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <div>&bull; <?= esc($error) ?></div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <?php $activeTab = session()->getFlashdata('active_tab') ?? '' ?>

        <!-- Tab Nav -->
        <div class="card mb-5">
            <div class="card-body pt-5 pb-0">
                <div class="d-flex overflow-auto h-55px justify-content-between align-items-center">
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6 active" data-bs-toggle="tab" href="#edit_data_diri">Data Diri</a>
                        </li>
                        <?php if ($user['id_role'] == 4): // Alumni 
                        ?>
                            <li class="nav-item">
                                <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#edit_tracer">Tracer Alumni</a>
                            </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#edit_berkas">Berkas</a>
                        </li>
                    </ul>
                    <a href="<?= site_url('admin/data-pelamar/profil/' . $user['id']) ?>" class="btn btn-sm btn-light">
                        &larr; Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">

            <!-- Tab Data Diri -->
            <div class="tab-pane fade show active" id="edit_data_diri">
                <form action="<?= site_url('admin/data-pelamar/profil/' . $user['id'] . '/update') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <!-- Kolom Kiri: Foto & Status -->
                        <div class="col-md-4 mb-5">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column align-items-center pt-10">
                                    <?php $foto = $pelamar['foto'] ?? null; ?>
                                    <img src="<?= $foto ? base_url('uploads/foto/' . $foto) : base_url('assets/media/avatars/blank.png') ?>"
                                        alt="foto" class="rounded mb-5" style="width:200px;height:200px;object-fit:cover;" />

                                    <div class="w-100 mb-5">
                                        <label class="fs-6 fw-semibold mb-2">Foto Profil</label>
                                        <input type="file" class="form-control form-control-solid" name="foto" accept="image/jpg,image/jpeg,image/png" />
                                        <div class="text-muted fs-7 mt-1">Format: JPG/PNG, maks 2MB.</div>
                                    </div>

                                    <div class="w-100">
                                        <label class="fs-6 fw-semibold mb-2">Status</label>
                                        <select class="form-control form-control-solid" name="is_active">
                                            <option value="1" <?= ($user['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Aktif</option>
                                            <option value="0" <?= ($user['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Nonaktif</option>
                                        </select>
                                    </div>

                                    <div class="w-100 mt-5">
                                        <label class="fs-6 fw-semibold mb-2">Status Pendaftaran</label>
                                        <select class="form-control form-control-solid" name="status_pendaftaran">
                                            <option value="menunggu_aktivasi" <?= ($pelamar['status_pendaftaran'] ?? 'menunggu_aktivasi') === 'menunggu_aktivasi' ? 'selected' : '' ?>>Menunggu Aktivasi</option>
                                            <option value="terdaftar" <?= ($pelamar['status_pendaftaran'] ?? '') === 'terdaftar' ? 'selected' : '' ?>>Terdaftar</option>
                                            <option value="aktif" <?= ($pelamar['status_pendaftaran'] ?? '') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Form Data -->
                        <div class="col-md-8 mb-5">
                            <div class="card">
                                <div class="card-body pt-8">
                                    <h4 class="fw-bolder mb-7">Data Diri</h4>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Nama</span></label>
                                            <input type="text" class="form-control form-control-solid"
                                                name="nama" value="<?= esc($user['nama']) ?>" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-semibold mb-2">NIK</label>
                                            <input type="text" class="form-control form-control-solid"
                                                name="nomer_nik" value="<?= esc($pelamar['nomer_nik'] ?? '') ?>" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Email</span></label>
                                            <input type="email" class="form-control form-control-solid"
                                                name="email" value="<?= esc($user['email']) ?>" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-semibold mb-2">No. Telepon</label>
                                            <input type="text" class="form-control form-control-solid"
                                                name="telepon" value="<?= esc($pelamar['telepon'] ?? '') ?>" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-semibold mb-2">Tanggal Lahir</label>
                                            <input type="date" class="form-control form-control-solid"
                                                name="tanggal_lahir" value="<?= $pelamar['tanggal_lahir'] ?? '' ?>" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-semibold mb-2">Tempat Lahir</label>
                                            <input type="text" class="form-control form-control-solid"
                                                name="tempat_lahir" value="<?= esc($pelamar['tempat_lahir'] ?? '') ?>" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="fs-6 fw-semibold mb-2">Jenis Kelamin</label>
                                            <select class="form-control form-control-solid" name="jenis_kelamin">
                                                <option value="">-- Pilih --</option>
                                                <option value="L" <?= ($pelamar['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                                <option value="P" <?= ($pelamar['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-semibold mb-2">Password (opsional)</label>
                                            <input type="password" class="form-control form-control-solid"
                                                name="password" placeholder="Kosongkan jika tidak mengubah" />
                                        </div>
                                        <div class="col-12">
                                            <label class="fs-6 fw-semibold mb-2">Alamat</label>
                                            <textarea class="form-control form-control-solid" name="alamat" rows="3"><?= esc($pelamar['alamat'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <button type="submit" class="btn btn-primary px-10">
                            <i class="bi bi-save me-2"></i>Simpan Data Diri
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab Tracer Alumni -->
            <div class="tab-pane fade" id="edit_tracer">
                <?php if ($user['id_role'] == 4): // Alumni 
                ?>
                    <form action="<?= site_url('admin/data-pelamar/profil/' . $user['id'] . '/update-tracer') ?>" method="POST">
                        <?= csrf_field() ?>
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
                                <i class="bi bi-save me-2"></i>Update Data Tracer
                            </button>
                        </div>
                    </form>
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
            <div class="tab-pane fade" id="edit_berkas">
                <div class="card shadow-sm">
                    <div class="card-header border-bottom pt-2">
                        <h3 class="card-title fw-bolder">Berkas Dokumen</h3>
                    </div>
                    <div class="card-body pt-10">
                        <div class="list-group list-group-flush">
                            <?php
                            $iconMap = [
                                'cv' => 'bi-file-person',
                                'surat_lamaran' => 'bi-file-earmark-text',
                                'ijazah' => 'bi-award',
                                'ktp' => 'bi-card-image',
                                'skck' => 'bi-shield-check',
                            ];
                            foreach (($jenisBerkas ?? []) as $index => $info):
                                $warna = ['primary', 'warning', 'success', 'info', 'danger'][$index % 5];
                                $kode = $info['kode'] ?? '';
                                if ($kode === 'surat_lamaran') {
                                    continue;
                                }
                                $item = $berkas[$kode] ?? null;
                            ?>
                                <div class="list-group-item p-4 mb-3">
                                    <div class="row align-items-center">

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

                                        <div class="col-md-3 text-md-center mt-3 mt-md-0">
                                            <span class="badge badge-light-<?= $item ? 'success' : 'secondary' ?>">
                                                <?= $item ? 'Sudah upload' : 'Belum upload' ?>
                                            </span>
                                        </div>

                                        <div class="col-md-4 d-flex justify-content-md-end align-items-center gap-2 mt-3 mt-md-0">
                                            <?php if ($item): ?>
                                                <a href="<?= base_url($item['path_file']) ?>" target="_blank" class="btn btn-sm btn-light-success">
                                                    Lihat
                                                </a>
                                            <?php endif ?>

                                            <form action="<?= site_url('admin/data-pelamar/profil/' . $user['id'] . '/upload-berkas') ?>" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
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
            </div>
        </div>
    </div>
</div>

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

            // Sembunyikan semua sections tanpa di-disable
            Object.keys(sections).forEach(function(key) {
                var section = sections[key];
                if (section) {
                    section.style.display = 'none';
                }
            });

            // Tampilkan section aktif
            if (slug && sections[slug]) {
                sections[slug].style.display = 'block';
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

            // Ulang untuk memastikan
            Object.values(sections).forEach(function(s) {
                if (s) s.style.display = 'none';
            });

            if (slug && sections[slug]) {
                sections[slug].style.display = 'block';
            }
        }

        if (aktivitasSelect) {
            aktivitasSelect.addEventListener('change', updateSections);
            updateSections(); // jalankan saat halaman load
        }

        // Jalankan ulang saat tab tracer dibuka
        var tracerTab = document.querySelector('a[href="#edit_tracer"]');
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

        var activeTab = '<?= esc($activeTab) ?>';
        if (activeTab) {
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

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        input.addEventListener('keyup', function(e) {
            let value = e.target.value;
            e.target.value = formatRupiah(value);
        });

        input.addEventListener('keydown', function(e) {
            let value = e.target.value;
            e.target.value = formatRupiah(value);
        });

        // Format saat halaman load
        input.value = formatRupiah(input.value);
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
