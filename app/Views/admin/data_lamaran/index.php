<?= $this->extend('admin/layout/app') ?>

<?= $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">

    <div class="card card-flush mb-4">
        <div class="card-body py-4">
            <form method="GET" action="<?= site_url('admin/data-lamaran') ?>">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Nama Perusahaan</label>
                        <input type="text" name="perusahaan" class="form-control form-control-solid" placeholder="Cari nama perusahaan" value="<?= esc($filters['perusahaan'] ?? '') ?>">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Posisi</label>
                        <input type="text" name="posisi" class="form-control form-control-solid" placeholder="Cari posisi" value="<?= esc($filters['posisi'] ?? '') ?>">
                    </div>
                    <div class="col-12 col-md-4">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <a href="<?= site_url('admin/data-lamaran') ?>" class="btn btn-light">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data Lamaran</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total Data Lamaran: <?= count($lamaran) ?></span>
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
                            <th class="min-w-150px">Nama Pelamar</th>
                            <th class="min-w-150px">Nama Perusahaan</th>
                            <th class="min-w-80px">Posisi</th>
                            <th class="min-w-120px">Tanggal Melamar</th>
                            <th class="min-w-120px">Tanggal Wawancara</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-100px">DiUbah Oleh</th>
                            <th class="min-w-150px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($lamaran)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($lamaran as $item): ?>
                                <tr>
                                    <td class="text-muted fw-bold fs-6 ps-5"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-bold text-hover-primary text-capitalize">
                                                <?= esc($item['nama_pelamar'] ?? '-') ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="text-dark fw-semibold">
                                                <?= esc($item['nama_perusahaan'] ?? '-') ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">
                                            <?= esc($item['posisi'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">
                                            <?= !empty($item['tanggal_melamar']) ? date('d/m/Y', strtotime($item['tanggal_melamar'])) : '-' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">
                                            <?= !empty($item['tanggal_wawancara']) ? date('d/m/Y', strtotime($item['tanggal_wawancara'])) : '-' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $status = $item['status'] ?? '';
                                        $statusClass = '';
                                        $statusText = ucfirst(str_replace('_', ' ', $status));

                                        switch ($status) {
                                            case 'menunggu_diverifikasi':
                                                $statusClass = 'badge-warning';
                                                $statusText = 'Menunggu Verifikasi';
                                                break;
                                            case 'diproses':
                                                $statusClass = 'badge-primary';
                                                $statusText = 'Diproses';
                                                break;
                                            case 'lolos_verifikasi':
                                                $statusClass = 'badge-success';
                                                $statusText = 'Lolos Verifikasi';
                                                break;
                                            case 'wawancara':
                                                $statusClass = 'badge-secondary';
                                                $statusText = 'Wawancara';
                                                break;
                                            case 'tidak_lolos':
                                                $statusClass = 'badge-danger';
                                                $statusText = 'Tidak Lolos';
                                                break;
                                            case 'diterima':
                                                $statusClass = 'badge-success';
                                                $statusText = 'Diterima';
                                                break;
                                            default:
                                                $statusClass = 'badge-light';
                                                $statusText = 'Unknown';
                                                break;
                                        }
                                        ?>
                                        <span class="badge <?= $statusClass ?> fs-7 fw-semibold">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light text-dark fs-7 fw-semibold">
                                            <?= esc($item['dibuat_oleh_nama'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="<?= site_url('admin/data-pelamar/profil/' . $item['id_user']) . '?tab=tab_berkas&id_lamaran=' . $item['id'] . '#tab_berkas' ?>"
                                            class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1"
                                            title="Lihat Pelamar">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M12 5C7.636 5 4.056 7.864 3 12C4.056 16.136 7.636 19 12 19C16.364 19 19.944 16.136 21 12C19.944 7.864 16.364 5 12 5Z" fill="currentColor" />
                                                    <circle cx="12" cy="12" r="3" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>
                                        <?php if (session()->get('id_role') != 2): ?>
                                            <button type="button"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                data-id="<?= $item['id'] ?>"
                                                data-status="<?= $item['status'] ?? '' ?>"
                                                data-tanggal-wawancara="<?= $item['tanggal_wawancara'] ?? '' ?>"
                                                data-catatan="<?= $item['catatan'] ?? '' ?>"
                                                title="Edit Status">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 7.45335 21.9962 7.97122 21.7817 8.35303 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </button>
                                        <?php endif; ?>
                                        <a href="<?= site_url('admin/data-lamaran/delete/' . $item['id']) ?>"
                                            class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-btn"
                                            data-title="Hapus Data Lamaran"
                                            data-text="Anda akan menghapus data lamaran &quot;<?= esc($item['nama_pelamar'] ?? '-') ?>&quot;. Tindakan ini tidak dapat dibatalkan!"
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
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data lamaran</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Body-->
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-600px">
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
                <form id="kt_modal_edit_form" method="POST" class="form" data-confirm-title="Ubah Status" data-confirm-text="Apakah Anda yakin ingin mengubah status data lamaran ini?">
                    <?= csrf_field() ?>
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Ubah Status Lamaran</h1>
                        <div class="text-muted fw-semibold fs-5">Pilih status baru untuk data lamaran</div>
                    </div>
                    <div class="row g-3 mb-8">
                        <div class="col-12">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2"><span class="required">Status</span></label>
                                <select class="form-control form-control-solid" name="status" id="editStatus" required>
                                    <option value="">Pilih Status</option>
                                    <option value="menunggu_diverifikasi">Menunggu Verifikasi</option>
                                    <option value="diproses">Diproses</option>
                                    <option value="lolos_verifikasi">Lolos Verifikasi</option>
                                    <option value="wawancara">Wawancara</option>
                                    <option value="tidak_lolos">Tidak Lolos</option>
                                    <option value="diterima">Diterima</option>
                                </select>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row d-none" id="fieldTanggalWawancara">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Tanggal Wawancara</span>
                                </label>
                                <input type="date" class="form-control form-control-solid" name="tanggal_wawancara" id="editTanggalWawancara">
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Catatan</label>
                                <textarea class="form-control form-control-solid" name="catatan" id="editCatatan" rows="3" placeholder="Masukkan catatan tambahan (opsional)"></textarea>
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
        const editStatusModal = document.getElementById('editModal');
        const editStatus = document.getElementById('editStatus');
        const fieldTanggalWawancara = document.getElementById('fieldTanggalWawancara');
        const editTanggalWawancara = document.getElementById('editTanggalWawancara');

        function toggleTanggalWawancara(status) {
            if (status === 'wawancara') {
                fieldTanggalWawancara.classList.remove('d-none');
                editTanggalWawancara.setAttribute('required', 'required');
            } else {
                fieldTanggalWawancara.classList.add('d-none');
                editTanggalWawancara.removeAttribute('required');
                editTanggalWawancara.value = '';
            }
        }

        editStatus.addEventListener('change', function() {
            toggleTanggalWawancara(this.value);
        });

        editStatusModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const status = button.getAttribute('data-status');
            const catatan = button.getAttribute('data-catatan');
            const tanggalWawancara = button.getAttribute('data-tanggal-wawancara');

            const form = document.getElementById('kt_modal_edit_form');
            const baseUrl = '<?= site_url('admin/data-lamaran/update/') ?>';
            form.setAttribute('action', baseUrl + id);

            document.getElementById('editStatus').value = status;
            document.getElementById('editCatatan').value = catatan;
            editTanggalWawancara.value = '';

            if (status === 'wawancara' && tanggalWawancara) {
                editTanggalWawancara.value = tanggalWawancara.substring(0, 10);
            }

            toggleTanggalWawancara(status);
        });
    });
</script>

<?= $this->endsection() ?>
