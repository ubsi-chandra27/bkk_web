<?= $this->extend('admin/layout/app') ?>
<?php $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data Admin</span>
                <?php
                $adminSekolah = 0;
                $adminDudi = 0;
                foreach ($admins as $a) {
                    if ($a['id_role'] == 2) $adminSekolah++;
                    if ($a['id_role'] == 3) $adminDudi++;
                }
                ?>
                <span class="text-muted mt-1 fw-semibold fs-7">Total <?= $adminSekolah ?> Admin Sekolah dan <?= $adminDudi ?> Admin DU/DI</span>
            </h3>

            <!-- ===== Modal Tambah Admin ===== -->
            <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-650px">
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
                            <form id="kt_modal_add_admin_form" action="<?= site_url('admin/data-admin') ?>" method="POST" class="form confirm-submit" enctype="multipart/form-data" data-confirm-title="Tambah Admin" data-confirm-text="Apakah Anda yakin ingin menambah admin baru?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Tambah Admin Baru</h1>
                                    <div class="text-muted fw-semibold fs-5">Silakan masukkan informasi Admin yang akan ditambahkan</div>
                                </div>
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
                                <div class="row g-3 mb-8">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Nama Admin</span></label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: John Doe" name="nama" value="<?= old('nama') ?>" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Email Admin</span></label>
                                            <input type="email" class="form-control form-control-solid" placeholder="Contoh: admin@example.com" name="email" value="<?= old('email') ?>" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Password Admin</span></label>
                                            <input type="password" class="form-control form-control-solid" placeholder="Minimal 6 karakter" name="password" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Jenis Admin</span></label>
                                            <select class="form-control form-control-solid" name="id_role">
                                                <option value="">Pilih Role</option>
                                                <?php foreach ($roles as $role): ?>
                                                    <option value="<?= $role['id'] ?>"><?= esc($role['nama_role']) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row d-none" id="fieldPerusahaan" style="display:none">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">Perusahaan DU/DI</span>
                                            </label>
                                            <select class="form-control form-control-solid" name="id_perusahaan" id="selectPerusahaan">
                                                <option value="">-- Pilih Perusahaan --</option>
                                                <?php foreach ($perusahaan as $p): ?>
                                                    <option value="<?= $p['id'] ?>">
                                                        <?= esc($p['nama_perusahaan']) ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Jenis Kelamin</span></label>
                                            <select class="form-control form-control-solid" name="jenis_kelamin">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Tempat Lahir</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: Jakarta" name="tempat_lahir" value="<?= old('tempat_lahir') ?>" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Tanggal Lahir</label>
                                            <input type="date" class="form-control form-control-solid" name="tanggal_lahir" value="<?= old('tanggal_lahir') ?>" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">No Telepon</span></label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: 081234567890" name="telepon" value="<?= old('telepon') ?>" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Alamat</label>
                                            <textarea class="form-control form-control-solid" name="alamat" rows="2"><?= old('alamat') ?></textarea>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Foto</label>
                                            <input type="file" class="form-control form-control-solid" name="foto" accept="image/*" />
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Simpan</span>
                                        <span class="indicator-progress">Mohon tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!--end::modal-content-->
                    </div>
                </div>
            </div>
            <!-- ===== /Modal Tambah Admin ===== -->

            <!-- ===== Modal Edit Admin ===== -->
            <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content rounded">
                        <!--begin::Modal header-->
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
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                            <form id="kt_modal_edit_admin_form" action="" method="POST" class="form confirm-submit" enctype="multipart/form-data" data-action-template="<?= site_url('admin/data-admin/update/:id') ?>" data-confirm-title="Edit Admin" data-confirm-text="Apakah Anda yakin ingin memperbarui data admin?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Edit Admin</h1>
                                    <div class="text-muted fw-semibold fs-5">Perbarui informasi Admin</div>
                                </div>
                                <div class="row g-3 mb-8">
                                    <!--begin::Col Kiri-->
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama Admin</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Nama Admin" name="nama" id="editNama" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Email Admin</label>
                                            <input type="email" class="form-control form-control-solid" placeholder="Email Admin" name="email" id="editEmail" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Password Admin</label>
                                            <input type="password" class="form-control form-control-solid" placeholder="Kosongkan jika tidak ingin mengubah" name="password" id="editPassword" />
                                            <div class="form-text text-muted fs-7">Kosongkan jika tidak ingin mengubah password</div>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Jenis Admin</span></label>
                                            <select class="form-control form-control-solid" name="id_role" id="editRole" required>
                                                <option value="">Pilih Role</option>
                                                <?php foreach ($roles as $role): ?>
                                                    <option value="<?= $role['id'] ?>"><?= esc($role['nama_role']) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row d-none" id="fieldPerusahaanEdit">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">Perusahaan DU/DI</span>
                                            </label>
                                            <select class="form-control form-control-solid" name="id_perusahaan" id="selectPerusahaanEdit">
                                                <option value="">-- Pilih Perusahaan --</option>
                                                <?php foreach ($semua_perusahaan as $p): ?>
                                                    <option value="<?= $p['id'] ?>">
                                                        <?= esc($p['nama_perusahaan']) ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Jenis Kelamin</label>
                                            <select class="form-control form-control-solid" name="jenis_kelamin" id="editJenisKelamin">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Status</label>
                                            <select class="form-control form-control-solid" name="is_active" id="editStatus">
                                                <option value="1">Aktif</option>
                                                <option value="0">Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--end::Col Kiri-->
                                    <!--begin::Col Kanan-->
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Tempat Lahir</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Tempat Lahir" name="tempat_lahir" id="editTempatLahir" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Tanggal Lahir</label>
                                            <input type="date" class="form-control form-control-solid" name="tanggal_lahir" id="editTanggalLahir" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">No Telepon</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="No Telepon" name="telepon" id="editTelepon" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Alamat</label>
                                            <textarea class="form-control form-control-solid" name="alamat" id="editAlamat" rows="2"></textarea>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Foto</label>
                                            <input type="file" class="form-control form-control-solid" name="foto" id="editFoto" accept="image/*" />
                                            <div class="form-text text-muted fs-7">Unggah foto baru untuk mengganti foto lama</div>
                                        </div>
                                    </div>
                                    <!--end::Col Kanan-->
                                </div>
                                <div class="text-center">
                                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Perbarui</span>
                                        <span class="indicator-progress">Mohon tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::modal-content-->
                </div>
            </div>
            <!-- ===== /Modal Edit Admin ===== -->

        </div>
        <!--end::card-header-->

        <!-- Search Box -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-3 px-5 px-md-8">
            <div class="position-relative w-100 w-md-auto">
                <span class="svg-icon svg-icon-1 position-absolute translate-middle-y top-50 ms-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                    </svg>
                </span>
                <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari Admin...">
            </div>
            <div class="card-toolbar w-100 w-md-auto">
                <button type="button" class="btn btn-sm btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                    <span class="svg-icon svg-icon-muted svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="black" />
                            <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z" fill="black" />
                        </svg>
                    </span>Tambah Admin
                </button>
            </div>
        </div>

        <!--begin::Body-->
        <div class="card-body py-3">
            <div class="table-responsive">
                <table id="kt_datatable_example_1" class="table table-hover align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="w-10px ps-4">No</th>
                            <th class="min-w-120px">Nama</th>
                            <th class="min-w-100px">Email</th>
                            <th class="min-w-80px">Role</th>
                            <th class="min-w-80px">JK</th>
                            <th class="min-w-100px">Telepon</th>
                            <th class="min-w-50px">Status</th>
                            <th class="min-w-100px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($admins) > 0): ?>
                            <?php $no = 1;
                            foreach ($admins as $item): ?>
                                <tr>
                                    <td class="text-muted fw-bold fs-6 ps-5"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px me-3">
                                                <img src="<?= !empty($item['foto']) ? base_url('uploads/foto/' . $item['foto']) : base_url('assets/media/avatars/blank.png') ?>" alt="<?= esc($item['nama']) ?>" />
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fw-bold text-hover-primary text-capitalize"><?= esc($item['nama']) ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc($item['email'] ?? '-') ?></td>
                                    <td>
                                        <?php
                                        $roleLabel = esc($item['nama_role'] ?? '-');
                                        $roleBadge = 'badge-light';
                                        if (isset($item['id_role'])) {
                                            if ($item['id_role'] == 1) $roleBadge = 'badge-danger';
                                            elseif ($item['id_role'] == 2) $roleBadge = 'badge-primary';
                                            elseif ($item['id_role'] == 3) $roleBadge = 'badge-info';
                                        }
                                        ?>
                                        <span class="badge <?= $roleBadge ?>"><?= $roleLabel ?></span>
                                    </td>
                                    <td><?= isset($item['jenis_kelamin']) ? ($item['jenis_kelamin'] == 'L' ? 'Laki-laki' : ($item['jenis_kelamin'] == 'P' ? 'Perempuan' : '-')) : '-' ?></td>
                                    <td><?= esc($item['telepon'] ?? '-') ?></td>
                                    <td>
                                        <?php if (isset($item['is_active']) && $item['is_active'] == 1): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Nonaktif</span>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button type="button"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editAdminModal"
                                            data-id="<?= $item['id'] ?>"
                                            data-nama="<?= esc($item['nama']) ?>"
                                            data-id_role="<?= $item['id_role'] ?>"
                                            data-id_perusahaan="<?= $item['id_perusahaan'] ?? '' ?>"
                                            data-email="<?= esc($item['email']) ?>"
                                            data-telepon="<?= esc($item['telepon'] ?? '') ?>"
                                            data-tempat_lahir="<?= esc($item['tempat_lahir'] ?? '') ?>"
                                            data-alamat="<?= esc($item['alamat'] ?? '') ?>"
                                            data-jenis_kelamin="<?= $item['jenis_kelamin'] ?? '' ?>"
                                            data-tanggal_lahir="<?= $item['tanggal_lahir'] ?? '' ?>"
                                            data-is_active="<?= $item['is_active'] ?? 1 ?>"
                                            title="Edit">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                        <a href="<?= site_url('admin/data-admin/delete/' . $item['id']) ?>"
                                            class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-btn"
                                            data-title="Hapus Admin"
                                            data-text="Anda akan menghapus admin &quot;<?= esc($item['nama']) ?>&quot;. Tindakan ini tidak dapat dibatalkan!"
                                            title="Hapus">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-10">
                                    <div class="text-gray-600 fs-5 fw-semibold">Belum ada data Admin</div>
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Body-->

    </div>
</div>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        const $dataTable = $('#kt_datatable_example_1').DataTable();
        const $search = $('#searchInput');
        if ($search.length) {
            $search.on('keyup', function() {
                $dataTable.search(this.value).draw();
            });
        }
    });

    // Show/hide perusahaan di modal EDIT berdasarkan role
    $(document).on('change', '#editAdminModal select[name="id_role"]', function() {
        const role = $(this).val();
        if (role == '3') {
            $('#fieldPerusahaanEdit').removeClass('d-none');
            $('#selectPerusahaanEdit').attr('required', true);
        } else {
            $('#fieldPerusahaanEdit').addClass('d-none');
            $('#selectPerusahaanEdit').val('').attr('required', false);
        }
    });

    // Saat tombol edit diklik, isi data termasuk perusahaan
    $(document).on('click', '[data-bs-target="#editAdminModal"]', function() {
        const button = $(this);
        const modal = $('#editAdminModal');
        const form = modal.find('#kt_modal_edit_admin_form');

        const id = button.data('id');
        const idRole = button.data('id_role');
        const idPerusahaan = button.data('id_perusahaan'); // tambah data attribute ini di tombol edit

        modal.find('#editNama').val(button.data('nama'));
        modal.find('#editEmail').val(button.data('email'));
        modal.find('#editRole').val(idRole);
        modal.find('#editJenisKelamin').val(button.data('jenis_kelamin'));
        modal.find('#editTempatLahir').val(button.data('tempat_lahir'));
        modal.find('#editTanggalLahir').val(button.data('tanggal_lahir'));
        modal.find('#editTelepon').val(button.data('telepon'));
        modal.find('#editAlamat').val(button.data('alamat'));
        modal.find('#editStatus').val(button.data('is_active'));

        // ✅ Tampilkan dropdown perusahaan jika role DU/DI
        if (idRole == 3) {
            $('#fieldPerusahaanEdit').removeClass('d-none');
            $('#selectPerusahaanEdit').val(idPerusahaan).attr('required', true);
        } else {
            $('#fieldPerusahaanEdit').addClass('d-none');
            $('#selectPerusahaanEdit').val('').attr('required', false);
        }

        const actionTemplate = form.data('action-template');
        form.attr('action', actionTemplate.replace(':id', id));
    });

    // Reset saat modal edit ditutup
    $('#editAdminModal').on('hidden.bs.modal', function() {
        $('#fieldPerusahaanEdit').addClass('d-none');
        $('#selectPerusahaanEdit').val('').attr('required', false);
    });
</script>
<?php $this->endSection() ?>