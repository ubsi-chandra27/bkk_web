<?= $this->extend('admin/layout/app') ?>
<?php $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data Pelamar</span>
                <?php
                $pelamarAlumni = 0;
                $pelamarUmum = 0;
                foreach ($pelamars as $p) {
                    $jenisPelamar = strtolower($p['jenis_pelamar'] ?? '');
                    if ($jenisPelamar == 'alumni') $pelamarAlumni++;
                    if ($jenisPelamar == 'umum') $pelamarUmum++;
                }
                ?>
                <span class="text-muted mt-1 fw-semibold fs-7">Total <?= $pelamarAlumni ?> Pelamar Alumni dan <?= $pelamarUmum ?> Pelamar Umum</span>
            </h3>

            <!-- ===== Modal Tambah Pelamar ===== -->
            <div class="modal fade" id="addPelamarModal" tabindex="-1" aria-labelledby="addPelamarModalLabel" aria-hidden="true">
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
                            <form id="kt_modal_add_pelamar_form" action="<?= site_url('admin/data-pelamar') ?>" method="POST" class="form confirm-submit" enctype="multipart/form-data" data-confirm-title="Tambah Pelamar" data-confirm-text="Apakah Anda yakin ingin menambah pelamar baru?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Tambah Pelamar Baru</h1>
                                    <div class="text-muted fw-semibold fs-5">Silakan masukkan informasi Pelamar yang akan ditambahkan</div>
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
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Nama Pelamar</span></label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: John Doe" name="nama" value="<?= old('nama') ?>" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Email Pelamar</span></label>
                                            <input type="email" class="form-control form-control-solid" placeholder="Contoh: pelamar@example.com" name="email" value="<?= old('email') ?>" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Password Pelamar</span></label>
                                            <input type="password" class="form-control form-control-solid" placeholder="Minimal 6 karakter" name="password" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Jenis Pelamar</span></label>
                                            <select class="form-control form-control-solid" name="jenis_pelamar">
                                                <option value="">Pilih Jenis Pelamar</option>
                                                <option value="alumni">Alumni</option>
                                                <option value="umum">Umum</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">No Telepon</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: 081234567890" name="telepon" value="<?= old('telepon') ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Jenis Kelamin</span></label>
                                            <select class="form-control form-control-solid" name="jenis_kelamin">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Tempat Lahir</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: Jakarta" name="tempat_lahir" value="<?= old('tempat_lahir') ?>" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Tanggal Lahir</label>
                                            <input type="date" class="form-control form-control-solid" name="tanggal_lahir" value="<?= old('tanggal_lahir') ?>" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Nomor NIK</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: 1234567890123456" name="nomer_nik" value="<?= old('nomer_nik') ?>" />
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
            <!-- ===== /Modal Tambah Pelamar ===== -->

            <!-- ===== Modal Edit Pelamar ===== -->
            <div class="modal fade" id="editPelamarModal" tabindex="-1" aria-labelledby="editPelamarModalLabel" aria-hidden="true">
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
                            <form id="kt_modal_edit_pelamar_form" action="" method="POST" class="form confirm-submit" enctype="multipart/form-data" data-action-template="<?= site_url('admin/data-pelamar/update/:id') ?>" data-confirm-title="Edit Pelamar" data-confirm-text="Apakah Anda yakin ingin memperbarui data pelamar?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Edit Pelamar</h1>
                                    <div class="text-muted fw-semibold fs-5">Perbarui informasi Pelamar</div>
                                </div>
                                <div class="row g-3 mb-8">
                                    <!--begin::Col Kiri-->
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama Pelamar</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Nama Pelamar" name="nama" id="editNama" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Email Pelamar</label>
                                            <input type="email" class="form-control form-control-solid" placeholder="Email Pelamar" name="email" id="editEmail" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Password Pelamar</label>
                                            <input type="password" class="form-control form-control-solid" placeholder="Kosongkan jika tidak ingin mengubah" name="password" id="editPassword" />
                                            <div class="form-text text-muted fs-7">Kosongkan jika tidak ingin mengubah password</div>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Jenis Pelamar</span></label>
                                            <select class="form-control form-control-solid" name="jenis_pelamar" id="editJenisPelamar" required>
                                                <option value="">Pilih Jenis Pelamar</option>
                                                <option value="alumni">Alumni</option>
                                                <option value="umum">Umum</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">No Telepon</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="No Telepon" name="telepon" id="editTelepon" />
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
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Jenis Kelamin</label>
                                            <select class="form-control form-control-solid" name="jenis_kelamin" id="editJenisKelamin">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Tempat Lahir</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Tempat Lahir" name="tempat_lahir" id="editTempatLahir" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Tanggal Lahir</label>
                                            <input type="date" class="form-control form-control-solid" name="tanggal_lahir" id="editTanggalLahir" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Nomor NIK</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Nomor NIK" name="nomer_nik" id="editNomerNik" />
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
            <!-- ===== /Modal Edit Pelamar ===== -->

            <!-- ===== Modal Edit Status Pendaftaran ===== -->
            <div class="modal fade" id="editStatusPendaftaranModal" tabindex="-1" aria-labelledby="editStatusPendaftaranModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-500px">
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
                            <form id="kt_modal_edit_status_pendaftaran_form" action="" method="POST" class="form confirm-submit" data-action-template="<?= site_url('admin/data-pelamar/update-status/:id') ?>" data-confirm-title="Ubah Status Pendaftaran" data-confirm-text="Apakah Anda yakin ingin memperbarui status pendaftaran pelamar ini?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Edit Status Pendaftaran</h1>
                                    <div class="text-muted fw-semibold fs-5">Perbarui status aktivasi untuk pelamar terpilih</div>
                                </div>
                                <div class="mb-8">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama Pelamar</label>
                                    <input type="text" class="form-control form-control-solid" id="statusPendaftaranNama" readonly />
                                </div>
                                <div class="mb-8">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Status Pendaftaran</span></label>
                                    <select class="form-control form-control-solid" name="status_pendaftaran" id="statusPendaftaranField" required>
                                        <option value="menunggu_aktivasi">Menunggu Aktivasi</option>
                                        <option value="terdaftar">Terdaftar</option>
                                        <option value="aktif">Aktif</option>
                                    </select>
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
                    </div>
                </div>
            </div>
            <!-- ===== /Modal Edit Status Pendaftaran ===== -->

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
                <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari Pelamar...">
            </div>
            <div class="card-toolbar w-100 w-md-auto">
                <button type="button" class="btn btn-sm btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#addPelamarModal">
                    <span class="svg-icon svg-icon-muted svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="black" />
                            <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z" fill="black" />
                        </svg>
                    </span>Tambah Pelamar
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
                            <th class="min-w-80px">Jenis Pelamar</th>
                            <th class="min-w-50px">Status</th>
                            <th class="min-w-140px">Aktivasi</th>
                            <th class="min-w-100px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($pelamars) > 0): ?>
                            <?php $no = 1;
                            foreach ($pelamars as $item): ?>
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
                                    <td class="text-capitalize">
                                        <?php
                                        $jenisLabel = esc($item['jenis_pelamar'] ?? '-');
                                        $jenisBadge = 'badge-light';
                                        if (isset($item['jenis_pelamar'])) {
                                            $jenisPelamar = strtolower($item['jenis_pelamar']);
                                            if ($jenisPelamar === 'alumni') {
                                                $jenisBadge = 'badge-primary';
                                            } elseif ($jenisPelamar === 'umum') {
                                                $jenisBadge = 'badge-info';
                                            }
                                        }
                                        ?>
                                        <span class="badge <?= $jenisBadge ?>"><?= $jenisLabel ?></span>
                                    </td>
                                    <td>
                                        <?php if (isset($item['is_active']) && $item['is_active'] == 1): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Nonaktif</span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php
                                        $statusPendaftaran = strtolower((string) ($item['status_pendaftaran'] ?? 'menunggu_aktivasi'));
                                        $statusPendaftaranLabel = 'Menunggu Aktivasi';
                                        $statusPendaftaranBadge = 'badge-light-warning';

                                        if ($statusPendaftaran === 'terdaftar') {
                                            $statusPendaftaranLabel = 'Terdaftar';
                                            $statusPendaftaranBadge = 'badge-light-info';
                                        } elseif ($statusPendaftaran === 'aktif') {
                                            $statusPendaftaranLabel = 'Aktif';
                                            $statusPendaftaranBadge = 'badge-light-success';
                                        }
                                        ?>
                                        <button type="button"
                                            class="badge <?= $statusPendaftaranBadge ?> border-0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editStatusPendaftaranModal"
                                            data-id="<?= $item['id_user'] ?>"
                                            data-nama="<?= esc($item['nama']) ?>"
                                            data-status_pendaftaran="<?= esc($statusPendaftaran) ?>"
                                            title="Klik untuk ubah status pendaftaran">
                                            <?= esc($statusPendaftaranLabel) ?>
                                        </button>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="<?= site_url('admin/data-pelamar/profil/' . $item['id_user']) ?>"
                                            class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1"
                                            title="Lihat Profil">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="black" />
                                                    <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="black" />
                                                </svg>
                                            </span>
                                        </a>
                                        <button type="button"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPelamarModal"
                                            data-id="<?= $item['id_user'] ?>"
                                            data-nama="<?= esc($item['nama']) ?>"
                                            data-email="<?= esc($item['email']) ?>"
                                            data-jenis_pelamar="<?= $item['jenis_pelamar'] ?? '' ?>"
                                            data-telepon="<?= esc($item['telepon'] ?? '') ?>"
                                            data-jenis_kelamin="<?= $item['jenis_kelamin'] ?? '' ?>"
                                            data-tempat_lahir="<?= esc($item['tempat_lahir'] ?? '') ?>"
                                            data-alamat="<?= esc($item['alamat'] ?? '') ?>"
                                            data-nomer_nik="<?= esc($item['nomer_nik'] ?? '') ?>"
                                            data-tanggal_lahir="<?= $item['tanggal_lahir'] ?? '' ?>"
                                            data-is_active="<?= $item['is_active'] ?? 1 ?>"
                                            title="Edit">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 7.45335 21.9962 7.97122 21.7817 8.35303 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                        <a href="<?= site_url('admin/data-pelamar/delete/' . $item['id_user']) ?>"
                                            class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-btn"
                                            data-title="Hapus Pelamar"
                                            data-text="Anda akan menghapus pelamar &quot;<?= esc($item['nama']) ?>&quot;. Tindakan ini tidak dapat dibatalkan!"
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
                                    <div class="text-gray-600 fs-5 fw-semibold">Belum ada data Pelamar</div>
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

    $(document).on('click', '[data-bs-target="#editPelamarModal"]', function() {
        const button = $(this);
        const modal = $('#editPelamarModal');
        const form = modal.find('#kt_modal_edit_pelamar_form');

        const id = button.data('id');

        modal.find('#editNama').val(button.data('nama'));
        modal.find('#editEmail').val(button.data('email'));
        modal.find('#editJenisPelamar').val(button.data('jenis_pelamar'));
        modal.find('#editTelepon').val(button.data('telepon'));
        modal.find('#editJenisKelamin').val(button.data('jenis_kelamin'));
        modal.find('#editTempatLahir').val(button.data('tempat_lahir'));
        modal.find('#editTanggalLahir').val(button.data('tanggal_lahir'));
        modal.find('#editNomerNik').val(button.data('nomer_nik'));
        modal.find('#editAlamat').val(button.data('alamat'));
        modal.find('#editStatus').val(button.data('is_active'));

        const actionTemplate = form.data('action-template');
        form.attr('action', actionTemplate.replace(':id', id));
    });

    $(document).on('click', '[data-bs-target="#editStatusPendaftaranModal"]', function() {
        const button = $(this);
        const modal = $('#editStatusPendaftaranModal');
        const form = modal.find('#kt_modal_edit_status_pendaftaran_form');
        const actionTemplate = form.data('action-template');

        modal.find('#statusPendaftaranNama').val(button.data('nama'));
        modal.find('#statusPendaftaranField').val(button.data('status_pendaftaran'));
        form.attr('action', actionTemplate.replace(':id', button.data('id')));
    });
</script>
<?php $this->endSection() ?>
