<?= $this->extend('admin/layout/app') ?>
<?= $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data Jurusan</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total <?= count($jurusan ?? []) ?> Jurusan</span>
            </h3>

            <!-- ===== Modal Tambah Jurusan ===== -->
            <div class="modal fade" id="addJurusanModal" tabindex="-1" aria-labelledby="addJurusanModalLabel" aria-hidden="true">
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
                            <form id="kt_modal_add_jurusan_form" action="<?= site_url('admin/data-jurusan') ?>" method="POST" class="form confirm-submit" enctype="multipart/form-data" data-confirm-title="Tambah Jurusan" data-confirm-text="Apakah Anda yakin ingin menambah jurusan baru?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Tambah Jurusan Baru</h1>
                                    <div class="text-muted fw-semibold fs-5">Silakan masukkan Nama Jurusan yang akan ditambahkan</div>
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
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Nama Jurusan</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Contoh: Teknik Informatika" name="kompetensi_keahlian" />
                                </div>
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Kode</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Contoh: TI" name="akronim" />
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
            <!-- ===== /Modal Tambah jurusan ===== -->

            <!-- ===== Modal Edit Jurusan ===== -->
            <div class="modal fade" id="editJurusanModal" tabindex="-1" aria-labelledby="editJurusanModalLabel" aria-hidden="true">
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
                            <form id="kt_modal_edit_jurusan_form" action="" method="POST" class="form confirm-submit" enctype="multipart/form-data" data-action-template="<?= site_url('admin/data-jurusan/update/:id') ?>" data-confirm-title="Edit Jurusan" data-confirm-text="Apakah Anda yakin ingin memperbarui data jurusan?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Edit Jurusan</h1>
                                    <div class="text-muted fw-semibold fs-5">Perbarui Data Jurusan</div>
                                </div>
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Nama Jurusan</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" id="editKompetensiKeahlian" class="form-control form-control-solid" placeholder="Enter Kompetensi Keahlian" name="kompetensi_keahlian" />
                                </div>
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Kode</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" id="editAkronim" class="form-control form-control-solid" placeholder="Enter Akronim" name="akronim" />
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
            <!-- ===== /Modal Edit jurusan ===== -->

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
                <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari Jurusan...">
            </div>
            <div class="card-toolbar w-100 w-md-auto">
                <button type="button" class="btn btn-sm btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#addJurusanModal">
                    <span class="svg-icon svg-icon-muted svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="black" />
                            <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z" fill="black" />
                        </svg>
                    </span>Tambah Jurusan
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
                            <th class="min-w-100px">Nama Jurusan</th>
                            <th class="min-w-50px">Kode</th>
                            <th class="min-w-100px">Terserap</th>
                            <th class="min-w-100px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($jurusan) > 0): ?>
                            <?php $no = 1;
                            foreach ($jurusan as $item): ?>
                                <tr>
                                    <td class="text-muted fw-bold fs-6 ps-5"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-bold text-hover-primary"><?= esc($item['kompetensi_keahlian']) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-primary fs-7 fw-bold"><?= esc($item['akronim']) ?></span>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-bold"><?= esc($item['terserapan'] ?? 0) ?></span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button type="button"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editJurusanModal"
                                            data-id="<?= $item['id'] ?>"
                                            data-nama-jurusan="<?= esc($item['kompetensi_keahlian']) ?>"
                                            data-kode="<?= esc($item['akronim']) ?>"

                                            title="Edit">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 7.45335 21.9962 7.97122 21.7817 8.35303 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                        <a href="<?= site_url('admin/data-jurusan/delete/' . $item['id']) ?>"
                                            class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-btn"
                                            data-title="Hapus Jurusan"
                                            data-text="Anda akan menghapus jurusan &quot;<?= esc($item['kompetensi_keahlian']) ?>&quot;. Tindakan ini tidak dapat dibatalkan!"
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
                                <td colspan="5" class="text-center py-10">
                                    <div class="text-gray-600 fs-5 fw-semibold">Belum ada data Jurusan</div>
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

    $(document).on('click', '[data-bs-target="#editJurusanModal"]', function() {
        const button = $(this);
        const modal = $('#editJurusanModal');
        const form = modal.find('#kt_modal_edit_jurusan_form');
        const id = button.data('id');

        modal.find('#editKompetensiKeahlian').val(button.data('nama-jurusan'));
        modal.find('#editAkronim').val(button.data('kode'));

        const actionTemplate = form.data('action-template');
        form.attr('action', actionTemplate.replace(':id', id));
    });
</script>
<?php $this->endSection() ?>