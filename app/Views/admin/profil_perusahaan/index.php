<?= $this->extend('admin/layout/app') ?>

<?= $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">
    <div class="card shadow-sm mb-5 mb-xl-10" id="profilPerusahaanCard">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Profil Perusahaan</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Kelola informasi perusahaan DUDI Anda</span>
            </h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-primary" id="btnEditProfil">
                    <i class="bi bi-pencil-square me-1"></i>Edit Profil
                </button>
            </div>
        </div>

        <div class="card-body py-5">
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

            <?php if (!$perusahaan): ?>
                <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-warning">Data perusahaan tidak ditemukan</h4>
                        <span>Akun ini belum terhubung dengan data perusahaan. Silakan hubungi admin BKK.</span>
                    </div>
                </div>
            <?php else: ?>
                <!-- View Mode -->
                <div id="viewMode">
                    <div class="d-flex flex-wrap flex-sm-nowrap mb-8">
                        <!-- Logo -->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-165px symbol-fixed position-relative">
                                <?php if (!empty($perusahaan['logo'])): ?>
                                    <img src="<?= base_url('uploads/logo/' . $perusahaan['logo']) ?>" alt="Logo Perusahaan" />
                                <?php else: ?>
                                    <span class="symbol-label bg-light-primary">
                                        <i class="fa-solid fa-building fs-2 text-primary"></i>
                                    </span>
                                <?php endif ?>
                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-<?= ((int) $perusahaan['is_active'] === 1) ? 'success' : 'danger' ?> rounded-circle border border-4 border-white h-20px w-20px"></div>
                            </div>
                        </div>

                        <!-- Company Info -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="text-gray-900 fs-2 fw-bolder me-3"><?= esc($perusahaan['nama_perusahaan'] ?: 'Belum diisi') ?></span>
                                        <span class="badge badge-light-<?= ((int) $perusahaan['is_active'] === 1) ? 'success' : 'danger' ?> px-3 py-2">
                                            <?= ((int) $perusahaan['is_active'] === 1) ? 'Aktif' : 'Tidak Aktif' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <?php if (!empty($perusahaan['bidang_usaha'])): ?>
                                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                        <span class="svg-icon svg-icon-4 me-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M19 19H5V5h14v14zm2-2V5c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v14c0 .55.45 1 1 1h16c.55 0 1-.45 1-1z" fill="black" />
                                            </svg>
                                        </span>
                                        <?= esc($perusahaan['bidang_usaha']) ?>
                                    </span>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-4"></div>

                    <!-- Detail Grid -->
                    <div class="row g-6">
                        <div class="col-md-6 col-12 mb-6">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-4 bg-light-primary rounded">
                                    <span class="symbol-label">
                                        <i class="bi bi-telephone fs-4 text-primary"></i>
                                    </span>
                                </div>
                                <div>
                                    <div class="text-muted fs-7 mb-1">No. Telepon</div>
                                    <div class="fw-bolder fs-6"><?= esc($perusahaan['no_telepon'] ?: 'Belum diisi') ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-6">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-4 bg-light-info rounded">
                                    <span class="symbol-label">
                                        <i class="bi bi-envelope fs-4 text-info"></i>
                                    </span>
                                </div>
                                <div>
                                    <div class="text-muted fs-7 mb-1">Email</div>
                                    <div class="fw-bolder fs-6"><?= esc($perusahaan['email'] ?: 'Belum diisi') ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-6">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-4 bg-light-success rounded">
                                    <span class="symbol-label">
                                        <i class="bi bi-geo-alt fs-4 text-success"></i>
                                    </span>
                                </div>
                                <div>
                                    <div class="text-muted fs-7 mb-1">Kota</div>
                                    <div class="fw-bolder fs-6"><?= esc($perusahaan['kota'] ?: 'Belum diisi') ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-6">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-4 bg-light-warning rounded">
                                    <span class="symbol-label">
                                        <i class="bi bi-globe fs-4 text-warning"></i>
                                    </span>
                                </div>
                                <div>
                                    <div class="text-muted fs-7 mb-1">Website</div>
                                    <div class="fw-bolder fs-6"><?= esc($perusahaan['website'] ?: 'Belum diisi') ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-6">
                            <div class="d-flex align-items-start">
                                <div class="symbol symbol-40px me-4 bg-light-danger rounded">
                                    <span class="symbol-label">
                                        <i class="bi bi-map fs-4 text-danger"></i>
                                    </span>
                                </div>
                                <div>
                                    <div class="text-muted fs-7 mb-1">Alamat</div>
                                    <div class="fw-bolder fs-6"><?= esc($perusahaan['alamat'] ?: 'Belum diisi') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div id="editMode" class="d-none">
                    <form action="<?= site_url('admindudi/profil-perusahaan/update') ?>" method="POST" id="profilForm" enctype="multipart/form-data" class="confirm-submit" data-confirm-title="Simpan Perubahan" data-confirm-text="Apakah Anda yakin ingin memperbarui profil perusahaan?">
                        <?= csrf_field() ?>

                        <div class="row g-6 mb-8">
                            <div class="col-lg-4">
                                <div class="border border-dashed rounded p-8 h-100 text-center">
                                    <div class="mb-5" id="logoPreviewContainer">
                                        <?php if (!empty($perusahaan['logo'])): ?>
                                            <img src="<?= base_url('uploads/logo/' . $perusahaan['logo']) ?>" alt="Logo Perusahaan" id="logoPreview" class="img-fluid rounded" style="max-height: 140px; object-fit: contain;">
                                        <?php else: ?>
                                            <div class="symbol symbol-100px mx-auto" id="logoPlaceholder">
                                                <span class="symbol-label bg-light-primary">
                                                    <i class="fa-solid fa-building fs-1 text-primary"></i>
                                                </span>
                                            </div>
                                            <img src="" alt="Preview Logo" id="logoPreview" class="img-fluid rounded d-none" style="max-height: 140px; object-fit: contain;">
                                        <?php endif ?>
                                    </div>
                                    <div class="fw-bold fs-5 text-gray-800 mb-1"><?= esc($perusahaan['nama_perusahaan'] ?: 'Nama Perusahaan') ?></div>
                                    <div class="text-muted fs-7 mb-6"><?= esc($perusahaan['bidang_usaha'] ?: 'Bidang Usaha') ?></div>

                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Logo Perusahaan</label>
                                    <input type="file" class="form-control form-control-solid" name="logo" id="logoInput" accept="image/jpeg,image/jpg,image/png">
                                    <small class="text-muted d-block mt-2">Format JPG/PNG, maksimal 2MB. Biarkan kosong jika tidak ingin mengubah logo.</small>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="row g-5">
                                    <div class="col-md-6 col-12">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Nama Perusahaan</span></label>
                                            <input type="text" class="form-control form-control-solid" name="nama_perusahaan" value="<?= old('nama_perusahaan', $perusahaan['nama_perusahaan']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Bidang Usaha</span></label>
                                            <input type="text" class="form-control form-control-solid" name="bidang_usaha" value="<?= old('bidang_usaha', $perusahaan['bidang_usaha']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Kota</span></label>
                                            <input type="text" class="form-control form-control-solid" name="kota" value="<?= old('kota', $perusahaan['kota']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">No. Telepon</span></label>
                                            <input type="text" class="form-control form-control-solid" name="no_telepon" value="<?= old('no_telepon', $perusahaan['no_telepon']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Email</span></label>
                                            <input type="email" class="form-control form-control-solid" name="email" value="<?= old('email', $perusahaan['email']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Website</span></label>
                                            <input type="text" class="form-control form-control-solid" name="website" value="<?= old('website', $perusahaan['website']) ?>" placeholder="https://www.perusahaan.co.id">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Alamat</span></label>
                                            <textarea class="form-control form-control-solid" name="alamat" rows="4" required><?= old('alamat', $perusahaan['alamat']) ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-light" id="btnBatalEdit">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan Perubahan</span>
                                <span class="indicator-progress">Mohon tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewMode = document.getElementById('viewMode');
        const editMode = document.getElementById('editMode');
        const btnEdit = document.getElementById('btnEditProfil');
        const btnBatal = document.getElementById('btnBatalEdit');
        const logoInput = document.getElementById('logoInput');
        const logoPreview = document.getElementById('logoPreview');
        const logoPlaceholder = document.getElementById('logoPlaceholder');

        // Toggle to edit mode
        btnEdit?.addEventListener('click', function() {
            viewMode?.classList.add('d-none');
            editMode?.classList.remove('d-none');
            btnEdit?.classList.add('d-none');
        });

        // Toggle to view mode (cancel edit)
        btnBatal?.addEventListener('click', function() {
            editMode?.classList.add('d-none');
            viewMode?.classList.remove('d-none');
            btnEdit?.classList.remove('d-none');
            logoInput.value = '';
            if (!logoPreview.src || logoPreview.classList.contains('d-none')) {
                logoPreview.classList.add('d-none');
                logoPlaceholder?.classList.remove('d-none');
            }
        });

        // Logo preview on file select
        logoInput?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    logoPreview.src = e.target.result;
                    logoPreview.classList.remove('d-none');
                    logoPlaceholder?.classList.add('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle success message - hide edit mode if opened
        <?php if (session()->getFlashdata('success')): ?>
            editMode?.classList.add('d-none');
            viewMode?.classList.remove('d-none');
            btnEdit?.classList.remove('d-none');
        <?php endif ?>
    });
</script>
<?= $this->endSection() ?>