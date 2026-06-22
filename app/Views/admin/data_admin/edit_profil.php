<?= $this->extend('admin/layout/app') ?>

<?= $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger d-flex align-items-center p-5 mb-8">
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-danger">Terdapat kesalahan!</h4>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <span>&bull; <?= esc($error) ?></span>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>

    <style>
    .password-strength-meter { margin-top: 10px; }
    .strength-bar { height: 6px; background-color: #e9ecef; border-radius: 3px; overflow: hidden; }
    .strength-progress { height: 100%; width: 0%; transition: width 0.3s ease, background-color 0.3s ease; }
    .strength-text .text-success { color: #50cd89; }
    .strength-text .text-warning { color: #ffc107; }
    .strength-text .text-danger { color: #f1416c; }
    .password-requirements li { transition: color 0.3s ease; }
    .password-requirements li.text-success { color: #50cd89 !important; }
    </style>

    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Edit Profil Admin</span>
                <span class="text-muted mt-1 fw-semibold fs-7"><?= esc($admin['nama'] ?? 'Admin') ?></span>
            </h3>
            <div class="card-toolbar">
                <a href="<?= base_url('admin/data-admin/' . ($admin['id'] ?? 0) . '/profil') ?>" class="btn btn-sm btn-light">
                    <i class="bi bi-arrow-left fs-6"></i> Batal
                </a>
            </div>
        </div>

        <div class="card-body py-5">
            <form action="<?= site_url('admin/data-admin/' . ($admin['id'] ?? 0) . '/update-profil') ?>" method="POST" enctype="multipart/form-data" id="editProfilForm">
                <?= csrf_field() ?>
                <input type="hidden" name="old_foto" value="<?= esc($admin['foto'] ?? '') ?>">
                <input type="hidden" name="target_role" value="<?= esc($admin['id_role'] ?? 0) ?>">
                <input type="hidden" name="id_perusahaan" value="<?= esc($admin['id_perusahaan'] ?? '') ?>">

                <div class="row g-6 mb-8">
                    <div class="col-lg-3">
                        <div class="border border-dashed rounded p-8 h-100 text-center">
                            <div class="mb-5" id="fotoPreviewContainer">
                                <?php
                                $fotoFile = $admin['foto'] ?? '';
                                $fotoUrl = '';
                                if (!empty($fotoFile)) {
                                    if (is_file(FCPATH . 'uploads/foto/' . $fotoFile)) {
                                        $fotoUrl = base_url('uploads/foto/' . $fotoFile);
                                    }
                                }
                                ?>
                                <?php if (!empty($fotoUrl)): ?>
                                    <img src="<?= $fotoUrl ?>" alt="Foto Profil" id="fotoPreview" class="img-fluid rounded" style="max-height: 140px; object-fit: contain;">
                                <?php else: ?>
                                    <div class="symbol symbol-100px symbol-lg-140px symbol-fixed mx-auto" id="fotoPlaceholder">
                                        <span class="symbol-label bg-light-primary text-primary fw-bolder fs-1"><?= strtoupper(substr(trim($admin['nama'] ?? 'A'), 0, 1)) ?></span>
                                    </div>
                                    <img src="" alt="Preview Foto" id="fotoPreview" class="img-fluid rounded d-none" style="max-height: 140px; object-fit: contain;">
                                <?php endif ?>
                            </div>
                            <div class="fw-bold fs-5 text-gray-800 mb-1"><?= esc($admin['nama'] ?? 'Admin') ?></div>
                            <div class="text-muted fs-7 mb-6"><?= esc($admin['nama_role'] ?? 'Admin') ?></div>

                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Foto Profil</label>
                            <input type="file" class="form-control form-control-solid" name="foto" id="fotoInput" accept="image/jpeg,image/jpg,image/png">
                            <small class="text-muted d-block mt-2">Format JPG/PNG, maksimal 2MB. Biarkan kosong jika tidak ingin mengubah foto.</small>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="row g-5">
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Nama Lengkap</span></label>
                                    <input type="text" class="form-control form-control-solid" name="nama" value="<?= old('nama', $admin['nama'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Email</span></label>
                                    <input type="email" class="form-control form-control-solid" name="email" value="<?= old('email', $admin['email'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">No. HP</label>
                                    <input type="text" class="form-control form-control-solid" name="telepon" value="<?= old('telepon', $admin['telepon'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Username</label>
                                    <input type="text" class="form-control form-control-solid bg-light" value="<?= esc($admin['email'] ?? '') ?>" readonly tabindex="-1">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Role</label>
                                    <input type="text" class="form-control form-control-solid bg-light" value="<?= esc($admin['nama_role'] ?? '') ?>" readonly tabindex="-1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-5 mb-xl-10">
                    <div class="card-header">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Ganti Password</h3>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="row g-5">
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Password Baru</label>
                                    <input type="password" class="form-control form-control-solid" name="password" id="editProfilPassword" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}" title="Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol." autocomplete="new-password">
                                    <small class="text-muted fs-7">Kosongkan jika tidak ingin mengubah password</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="password-strength-meter" id="editProfilPasswordMeter">
                                    <div class="strength-bar">
                                        <div class="strength-progress" id="editProfilStrengthProgress" style="width: 0%; background-color: #e9ecef;"></div>
                                    </div>
                                    <div class="strength-text mt-2" id="editProfilStrengthText">Kekuatan password: <span class="text-muted">Belum diisi</span></div>
                                    <ul class="password-requirements list-unstyled mt-2">
                                        <li id="editProfil-req-length" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Minimal 8 karakter</li>
                                        <li id="editProfil-req-uppercase" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung huruf besar (A-Z)</li>
                                        <li id="editProfil-req-lowercase" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung huruf kecil (a-z)</li>
                                        <li id="editProfil-req-number" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung angka (0-9)</li>
                                        <li id="editProfil-req-symbol" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung karakter simbol (!@#$%^&* dll)</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control form-control-solid" name="konfirmasi_password" autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ((int) ($admin['id_role'] ?? 0) === 3): ?>
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Data Perusahaan</h3>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="row g-5">
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Nama Perusahaan</span></label>
                                    <input type="text" class="form-control form-control-solid" name="nama_perusahaan" value="<?= old('nama_perusahaan', $perusahaan['nama_perusahaan'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Bidang Usaha</span></label>
                                    <input type="text" class="form-control form-control-solid" name="bidang_usaha" value="<?= old('bidang_usaha', $perusahaan['bidang_usaha'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Kota</span></label>
                                    <input type="text" class="form-control form-control-solid" name="kota" value="<?= old('kota', $perusahaan['kota'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">No. Telepon</span></label>
                                    <input type="text" class="form-control form-control-solid" name="no_telepon" value="<?= old('no_telepon', $perusahaan['no_telepon'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Email Perusahaan</span></label>
                                    <input type="email" class="form-control form-control-solid" name="email_perusahaan" value="<?= old('email_perusahaan', $perusahaan['email'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Website</label>
                                    <input type="text" class="form-control form-control-solid" name="website" value="<?= old('website', $perusahaan['website'] ?? '') ?>" placeholder="https://www.perusahaan.co.id">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Alamat</span></label>
                                    <textarea class="form-control form-control-solid" name="alamat" rows="4" required><?= old('alamat', $perusahaan['alamat'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>

                <div class="d-flex justify-content-end gap-3">
                    <a href="<?= base_url('admin/data-admin/' . ($admin['id'] ?? 0) . '/profil') ?>" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan Perubahan</span>
                        <span class="indicator-progress">Mohon tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fotoInput = document.getElementById('fotoInput');
        const fotoPreview = document.getElementById('fotoPreview');
        const fotoPlaceholder = document.getElementById('fotoPlaceholder');

        fotoInput?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fotoPreview.src = e.target.result;
                    fotoPreview.classList.remove('d-none');
                    if (fotoPlaceholder) {
                        fotoPlaceholder.classList.add('d-none');
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        initPasswordMeter('editProfilPassword', 'editProfilStrengthProgress', 'editProfilStrengthText', [
            'editProfil-req-length', 'editProfil-req-uppercase', 'editProfil-req-lowercase', 'editProfil-req-number', 'editProfil-req-symbol'
        ]);
    });
</script>
<?= $this->endSection() ?>
