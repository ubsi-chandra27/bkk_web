<?= $this->extend('admin/layout/app') ?>
<?= $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data Perusahaan</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total <?= count($perusahaan ?? []) ?> Perusahaan</span>
            </h3>

            <!-- ===== Modal Tambah Perusahaan ===== -->
            <div class="modal fade" id="addPerusahaanModal" tabindex="-1" aria-labelledby="addPerusahaanModalLabel" aria-hidden="true">
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
                            <form id="kt_modal_add_perusahaan_form" action="<?= site_url('admin/data-perusahaan/store') ?>" method="POST" class="form confirm-submit" enctype="multipart/form-data" data-confirm-title="Tambah Perusahaan" data-confirm-text="Apakah Anda yakin ingin menambah perusahaan baru?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Tambah Perusahaan Baru</h1>
                                    <div class="text-muted fw-semibold fs-5">Silakan masukkan data perusahaan yang akan ditambahkan</div>
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
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Nama Perusahaan</span></label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: PT. XYZ" name="nama_perusahaan" value="<?= old('nama_perusahaan') ?>" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Bidang Usaha</span></label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: Teknologi Informasi" name="bidang_usaha" value="<?= old('bidang_usaha') ?>" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Alamat</span></label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: Jl. Merdeka No. 123" name="alamat" value="<?= old('alamat') ?>" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Kota</span></label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: Jakarta" name="kota" value="<?= old('kota') ?>" required />
                                        </div>

                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-3">
                                                Jenis Kerjasama
                                            </label>
                                            <div class="d-flex flex-column gap-3">
                                                <?php foreach ($kerjasama as $k): ?>
                                                    <label class="d-flex align-items-center gap-2 cursor-pointer">
                                                        <input type="checkbox"
                                                            class="form-check-input"
                                                            name="kerjasama[]"
                                                            value="<?= $k['id'] ?>" />
                                                        <span class="fs-6 fw-semibold text-gray-700">
                                                            <?= esc($k['nama_kerjasama']) ?>
                                                        </span>
                                                    </label>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">No. Telepon</span></label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: 021-12345678" name="no_telepon" value="<?= old('no_telepon') ?>" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Email</label>
                                            <input type="email" class="form-control form-control-solid" placeholder="Contoh: example@email.com" name="email" value="<?= old('email') ?>" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Website</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Contoh: https://www.example.com" name="website" value="<?= old('website') ?>" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Logo Perusahaan</label>
                                            <input type="file" class="form-control form-control-solid" name="logo" accept="image/*" />
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
                    </div>
                </div>
            </div>
            <!-- ===== /Modal Tambah Perusahaan ===== -->

            <!-- ===== Modal Edit Perusahaan ===== -->
            <div class="modal fade" id="editPerusahaanModal" tabindex="-1" aria-labelledby="editPerusahaanModalLabel" aria-hidden="true">
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
                            <form id="kt_modal_edit_perusahaan_form" action="" method="POST" class="form confirm-submit" enctype="multipart/form-data" data-action-template="<?= site_url('admin/data-perusahaan/update/:id') ?>" data-confirm-title="Edit Perusahaan" data-confirm-text="Apakah Anda yakin ingin memperbarui data perusahaan?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Edit Perusahaan</h1>
                                    <div class="text-muted fw-semibold fs-5">Perbarui Data Perusahaan</div>
                                </div>
                                <div class="row g-3 mb-8">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Nama Perusahaan</span>
                                            </label>
                                            <input type="text" id="editNamaPerusahaan" class="form-control form-control-solid" placeholder="Enter Nama Perusahaan" name="nama_perusahaan" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Bidang Usaha</span>
                                            </label>
                                            <input type="text" id="editBidangUsaha" class="form-control form-control-solid" placeholder="Enter Bidang Usaha" name="bidang_usaha" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Alamat</span>
                                            </label>
                                            <textarea id="editAlamat" class="form-control form-control-solid" placeholder="Enter Alamat" name="alamat"></textarea>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Kota</span>
                                            </label>
                                            <input type="text" id="editKota" class="form-control form-control-solid" placeholder="Enter Kota" name="kota" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-3">
                                                Jenis Kerjasama
                                            </label>
                                            <div class="d-flex flex-column gap-3" id="editKerjasamaList">
                                                <?php foreach ($kerjasama as $k): ?>
                                                    <label class="d-flex align-items-center gap-2 cursor-pointer">
                                                        <input type="checkbox"
                                                            class="form-check-input edit-kerjasama-cb"
                                                            name="kerjasama[]"
                                                            value="<?= $k['id'] ?>" />
                                                        <span class="fs-6 fw-semibold text-gray-700">
                                                            <?= esc($k['nama_kerjasama']) ?>
                                                        </span>
                                                    </label>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">No Telepon</span>
                                            </label>
                                            <input type="text" id="editNoTelepon" class="form-control form-control-solid" placeholder="Enter No Telepon" name="no_telepon" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Email</span>
                                            </label>
                                            <input type="email" id="editEmail" class="form-control form-control-solid" placeholder="Enter Email" name="email" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span>Website</span>
                                            </label>
                                            <input type="text" id="editWebsite" class="form-control form-control-solid" placeholder="Enter Website" name="website" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span>Logo Perusahaan</span>
                                            </label>
                                            <input type="file" class="form-control form-control-solid" name="logo" accept="image/*" />
                                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah logo. Format: JPG, PNG, maksimal 1MB</small>
                                            <div id="currentLogo" class="mt-2"></div>
                                        </div>
                                    </div>
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
                    </div>
                </div>
            </div>
            <!-- ===== /Modal Edit Perusahaan ===== -->

        </div>

        <!-- Search Box -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-3 px-5 px-md-8">
            <div class="position-relative w-100 w-md-auto">
                <span class="svg-icon svg-icon-1 position-absolute translate-middle-y top-50 ms-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                    </svg>
                </span>
                <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari Perusahaan...">
            </div>
            <div class="card-toolbar w-100 w-md-auto">
                <button type="button" class="btn btn-sm btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#addPerusahaanModal">
                    <span class="svg-icon svg-icon-muted svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="black" />
                            <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z" fill="black" />
                        </svg>
                    </span>Tambah Perusahaan
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
                            <th class="min-w-150px">Nama Perusahaan</th>
                            <th class="min-w-150px">Alamat</th>
                            <th class="min-w-80px">Kota</th>
                            <th class="min-w-100px">Kerja Sama</th>
                            <th class="min-w-100px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($perusahaan) > 0): ?>
                            <?php $no = 1;
                            foreach ($perusahaan as $item): ?>
                                <tr>
                                    <td class="text-muted fw-bold fs-6 ps-5"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($item['logo']): ?>
                                                <img src="/uploads/logo/<?= $item['logo'] ?>" alt="Logo" class="me-3" width="40" height="40" style="object-fit: cover; border-radius: 5px;">
                                            <?php endif; ?>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fw-bold text-hover-primary"><?= esc($item['nama_perusahaan']) ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-bold"><?= esc($item['alamat']) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-primary fs-7 fw-bold"><?= esc($item['kota']) ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($item['kerjasama'])): ?>
                                            <div class="d-flex flex-column gap-1">
                                                <?php foreach ($item['kerjasama'] as $ks): ?>
                                                    <span class="badge badge-light-primary fs-7 fw-bold">
                                                        <?= esc($ks) ?>
                                                    </span>
                                                <?php endforeach ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button type="button"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPerusahaanModal"
                                            data-id="<?= $item['id'] ?>"
                                            data-nama-perusahaan="<?= esc($item['nama_perusahaan']) ?>"
                                            data-bidang-usaha="<?= esc($item['bidang_usaha']) ?>"
                                            data-alamat="<?= esc($item['alamat']) ?>"
                                            data-kota="<?= esc($item['kota']) ?>"
                                            data-no-telepon="<?= esc($item['no_telepon']) ?>"
                                            data-email="<?= esc($item['email']) ?>"
                                            data-website="<?= esc($item['website']) ?>"
                                            data-logo="<?= esc($item['logo']) ?>"
                                            data-kerjasama="<?= esc(json_encode($kerjasamaPerPerusahaan[$item['id']] ?? [])) ?>"
                                            title="Edit">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 7.45335 21.9962 7.97122 21.7817 8.35303 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                        <a href="<?= site_url('admin/data-perusahaan/delete/' . $item['id']) ?>"
                                            class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-btn"
                                            data-title="Hapus Perusahaan"
                                            data-text="Anda akan menghapus perusahaan &quot;<?= esc($item['nama_perusahaan']) ?>&quot;. Tindakan ini tidak dapat dibatalkan!"
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
                                <td colspan="9" class="text-center py-10">
                                    <div class="text-gray-600 fs-5 fw-semibold">Belum ada data Perusahaan</div>
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

    $(document).on('click', '[data-bs-target="#editPerusahaanModal"]', function() {
        const button = $(this);
        const modal = $('#editPerusahaanModal');
        const form = modal.find('#kt_modal_edit_perusahaan_form');
        const id = button.data('id');

        modal.find('#editNamaPerusahaan').val(button.data('nama-perusahaan'));
        modal.find('#editBidangUsaha').val(button.data('bidang-usaha'));
        modal.find('#editAlamat').val(button.data('alamat'));
        modal.find('#editKota').val(button.data('kota'));
        modal.find('#editNoTelepon').val(button.data('no-telepon'));
        modal.find('#editEmail').val(button.data('email'));
        modal.find('#editWebsite').val(button.data('website'));

        const selectedKerjasama = button.data('kerjasama') || [];
        modal.find('.edit-kerjasama-cb').each(function() {
            $(this).prop('checked', selectedKerjasama.includes(parseInt($(this).val())));
        });

        const currentLogo = button.data('logo');
        const logoContainer = modal.find('#currentLogo');
        logoContainer.empty();
        if (currentLogo) {
            logoContainer.html('<img src="/uploads/logo/' + currentLogo + '" alt="Current Logo" width="100" height="100" style="object-fit: cover; border-radius: 5px;">');
        }

        const actionTemplate = form.data('action-template');
        form.attr('action', actionTemplate.replace(':id', id));
    });
</script>
<?php $this->endSection() ?>