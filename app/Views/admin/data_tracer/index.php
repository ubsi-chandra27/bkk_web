<?= $this->extend('admin/layout/app') ?>

<?= $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">

    <div class="card shadow-sm mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data Tracer Alumni</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Kelola data tracer alumni</span>
            </h3>
        </div>

        <!--begin::Body-->
        <div class="card-body py-3">
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success d-flex align-items-center p-5 mb-8">
                    <div class="d-flex flex-column">
                        <span><?= session()->getFlashdata('success') ?></span>
                    </div>
                </div>
            <?php endif ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger d-flex align-items-center p-5 mb-8">
                    <div class="d-flex flex-column">
                        <span><?= session()->getFlashdata('error') ?></span>
                    </div>
                </div>
            <?php endif ?>
            <div class="d-flex justify-content-start mt-3">
                <div class="position-relative w-100 w-md-auto">
                    <span class="svg-icon svg-icon-1 position-absolute translate-middle-y top-50 ms-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari Perusahaan...">
                </div>
            </div>

            <div class="table-responsive">
                <table id="kt_datatable_example_1" class="table table-hover align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="w-10px ps-4">No</th>
                            <th class="min-w-150px">Nama</th>
                            <th class="min-w-120px">Jurusan</th>
                            <th class="min-w-100px">Angkatan</th>
                            <th class="min-w-120px">Aktivitas</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-150px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tracers)): ?>
                            <?php $no = 1;
                            foreach ($tracers as $tracer): ?>
                                <tr>
                                    <td class="text-muted fw-bold fs-6 ps-5"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-bold text-hover-primary text-capitalize">
                                                <?= esc($tracer['nama'] ?? '-') ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">
                                            <?= esc($tracer['kompetensi_keahlian'] ?? '-') ?>
                                            <?php if (!empty($tracer['akronim'])): ?>
                                                (<?= esc($tracer['akronim']) ?>)
                                            <?php endif ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">
                                            <?= esc($tracer['tahun'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">
                                            <?= esc($tracer['nama_aktivitas'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $status = $tracer['status'] ?? '';
                                        $statusClass = '';
                                        $statusText = ucfirst(str_replace('_', ' ', $status));

                                        switch ($status) {
                                            case 'draft':
                                                $statusClass = 'badge-warning';
                                                break;
                                            case 'terkirim':
                                                $statusClass = 'badge-primary';
                                                break;
                                            case 'terverifikasi':
                                                $statusClass = 'badge-success';
                                                break;
                                            case 'disetujui':
                                                $statusClass = 'badge-info';
                                                break;
                                            default:
                                                $statusClass = 'badge-warning';
                                                $statusText = 'Menunggu';
                                                break;
                                        }
                                        ?>
                                        <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="<?= site_url('admin/data-pelamar/profil/' . $tracer['id_user']) ?>"
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
                                            data-bs-target="#editStatusModal"
                                            data-id="<?= $tracer['id'] ?>"
                                            data-status="<?= $tracer['status'] ?? '' ?>"
                                            title="Edit Status">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 7.45335 21.9962 7.97122 21.7817 8.35303 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                        <a href="<?= site_url('admin/data-tracer/delete/' . $tracer['id']) ?>"
                                            class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-btn"
                                            data-title="Hapus Data Tracer"
                                            data-text="Anda akan menghapus data tracer alumni &quot;<?= esc($tracer['nama']) ?>&quot;. Tindakan ini tidak dapat dibatalkan!"
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
                                <td colspan="7" class="text-center py-10">
                                    <div class="text-gray-600 fs-5 fw-semibold">Belum ada data tracer alumni</div>
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

<!-- Modal Edit Status -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
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
                <form id="kt_modal_edit_status_form" action="" method="POST" class="form confirm-submit" data-confirm-title="Ubah Status" data-confirm-text="Apakah Anda yakin ingin mengubah status data tracer ini?">
                    <?= csrf_field() ?>
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Ubah Status Tracer</h1>
                        <div class="text-muted fw-semibold fs-5">Perbarui Status Tracer Alumni</div>
                    </div>
                    <div class="row g-3 mb-8">
                        <div class="col-12">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Status</span></label>
                                <select class="form-control form-control-solid" name="status" id="editStatus" required>
                                    <option value="">Pilih Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="terkirim">Terkirim</option>
                                    <option value="terverifikasi">Terverifikasi</option>
                                    <option value="disetujui">Disetujui</option>
                                </select>
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
<?= $this->endsection() ?>
<?= $this->section('scripts') ?>
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
    document.addEventListener('DOMContentLoaded', function() {
        const editStatusModal = document.getElementById('editStatusModal');
        editStatusModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const status = button.getAttribute('data-status');

            const form = editStatusModal.querySelector('form');
            form.action = `<?= site_url('admin/data-tracer/update/') ?>${id}`;

            const statusSelect = editStatusModal.querySelector('#editStatus');
            statusSelect.value = status;
        });
    });
</script>

<?= $this->endsection() ?>