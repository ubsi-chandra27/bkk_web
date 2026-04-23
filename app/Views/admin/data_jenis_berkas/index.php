<?= $this->extend('admin/layout/app') ?>
<?= $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data Jenis Berkas</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total <?= count($jenisBerkas ?? []) ?> Jenis Berkas</span>
            </h3>

            <div class="modal fade" id="addJenisBerkasModal" tabindex="-1" aria-hidden="true">
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
                            <form action="<?= site_url('admin/data-jenis-berkas') ?>" method="POST" class="form confirm-submit" data-confirm-title="Tambah Jenis Berkas" data-confirm-text="Apakah Anda yakin ingin menambah jenis berkas baru?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Tambah Jenis Berkas</h1>
                                    <div class="text-muted fw-semibold fs-5">Tambahkan master jenis berkas baru untuk kebutuhan lowongan dan pelamar</div>
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
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Nama Berkas</span></label>
                                        <input type="text" class="form-control form-control-solid" name="nama_berkas" placeholder="Contoh: Portofolio" value="<?= old('nama_berkas') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Slug</span></label>
                                        <input type="text" class="form-control form-control-solid" name="slug_berkas" placeholder="Contoh: portofolio" value="<?= old('slug_berkas') ?>" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Berlaku Untuk</span></label>
                                        <select class="form-control form-control-solid" name="berlaku_untuk">
                                            <option value="semua">Semua</option>
                                            <option value="pelamar">Pelamar</option>
                                            <option value="lowongan">Lowongan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Status</span></label>
                                        <select class="form-control form-control-solid" name="status_aktif">
                                            <option value="1">Aktif</option>
                                            <option value="0">Nonaktif</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">Keterangan</label>
                                        <textarea class="form-control form-control-solid" name="keterangan" rows="3" placeholder="Keterangan singkat berkas"><?= old('keterangan') ?></textarea>
                                    </div>
                                </div>
                                <div class="text-center mt-8">
                                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editJenisBerkasModal" tabindex="-1" aria-hidden="true">
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
                            <form id="editJenisBerkasForm" action="" method="POST" class="form confirm-submit" data-action-template="<?= site_url('admin/data-jenis-berkas/update/:id') ?>" data-confirm-title="Edit Jenis Berkas" data-confirm-text="Apakah Anda yakin ingin memperbarui jenis berkas ini?">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Edit Jenis Berkas</h1>
                                    <div class="text-muted fw-semibold fs-5">Perbarui data master jenis berkas</div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Nama Berkas</span></label>
                                        <input type="text" class="form-control form-control-solid" id="editNamaBerkas" name="nama_berkas" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Slug</span></label>
                                        <input type="text" class="form-control form-control-solid" id="editSlugBerkas" name="slug_berkas" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Berlaku Untuk</span></label>
                                        <select class="form-control form-control-solid" id="editBerlakuUntuk" name="berlaku_untuk">
                                            <option value="semua">Semua</option>
                                            <option value="pelamar">Pelamar</option>
                                            <option value="lowongan">Lowongan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Status</span></label>
                                        <select class="form-control form-control-solid" id="editStatusAktif" name="status_aktif">
                                            <option value="1">Aktif</option>
                                            <option value="0">Nonaktif</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">Keterangan</label>
                                        <textarea class="form-control form-control-solid" id="editKeterangan" name="keterangan" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="text-center mt-8">
                                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-3 px-5 px-md-8">
            <div class="position-relative w-100 w-md-auto">
                <span class="svg-icon svg-icon-1 position-absolute translate-middle-y top-50 ms-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14 5Z" fill="currentColor" />
                    </svg>
                </span>
                <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari Jenis Berkas...">
            </div>
            <div class="card-toolbar w-100 w-md-auto">
                <button type="button" class="btn btn-sm btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#addJenisBerkasModal">
                    <span class="svg-icon svg-icon-muted svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="black" />
                            <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z" fill="black" />
                        </svg>
                    </span>Tambah Jenis Berkas
                </button>
            </div>
        </div>

        <div class="card-body py-3">
            <div class="table-responsive">
                <table id="kt_datatable_example_1" class="table table-hover align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="w-10px ps-4">No</th>
                            <th class="min-w-150px">Nama Berkas</th>
                            <th class="min-w-120px">Slug</th>
                            <th class="min-w-100px">Berlaku Untuk</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-180px">Keterangan</th>
                            <th class="min-w-100px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($jenisBerkas) > 0): ?>
                            <?php $no = 1; foreach ($jenisBerkas as $item): ?>
                                <tr>
                                    <td class="text-muted fw-bold fs-6 ps-5"><?= $no++ ?></td>
                                    <td><span class="text-dark fw-bold"><?= esc($item['nama_berkas']) ?></span></td>
                                    <td><span class="badge badge-light-primary"><?= esc($item['slug_berkas']) ?></span></td>
                                    <td><span class="badge badge-light-info text-capitalize"><?= esc($item['berlaku_untuk']) ?></span></td>
                                    <td>
                                        <span class="badge badge-<?= (int) $item['status_aktif'] === 1 ? 'success' : 'secondary' ?>">
                                            <?= (int) $item['status_aktif'] === 1 ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td><?= esc($item['keterangan'] ?? '-') ?></td>
                                    <td class="text-end pe-3">
                                        <button type="button"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editJenisBerkasModal"
                                            data-id="<?= $item['id_jenis_berkas'] ?>"
                                            data-nama_berkas="<?= esc($item['nama_berkas']) ?>"
                                            data-slug_berkas="<?= esc($item['slug_berkas']) ?>"
                                            data-berlaku_untuk="<?= esc($item['berlaku_untuk']) ?>"
                                            data-keterangan="<?= esc($item['keterangan'] ?? '') ?>"
                                            data-status_aktif="<?= esc($item['status_aktif']) ?>"
                                            title="Edit">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 7.45335 21.9962 7.97122 21.7817 8.35303 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                        <a href="<?= site_url('admin/data-jenis-berkas/delete/' . $item['id_jenis_berkas']) ?>"
                                            class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-btn"
                                            data-title="Hapus Jenis Berkas"
                                            data-text="Anda akan menghapus jenis berkas &quot;<?= esc($item['nama_berkas']) ?>&quot;. Tindakan ini tidak dapat dibatalkan!"
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
                                    <div class="text-gray-600 fs-5 fw-semibold">Belum ada data jenis berkas</div>
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
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

    $(document).on('click', '[data-bs-target="#editJenisBerkasModal"]', function() {
        const button = $(this);
        const modal = $('#editJenisBerkasModal');
        const form = modal.find('#editJenisBerkasForm');
        const id = button.data('id');

        modal.find('#editNamaBerkas').val(button.data('nama_berkas'));
        modal.find('#editSlugBerkas').val(button.data('slug_berkas'));
        modal.find('#editBerlakuUntuk').val(button.data('berlaku_untuk'));
        modal.find('#editKeterangan').val(button.data('keterangan'));
        modal.find('#editStatusAktif').val(button.data('status_aktif'));

        const actionTemplate = form.data('action-template');
        form.attr('action', actionTemplate.replace(':id', id));
    });
</script>
<?php $this->endSection() ?>
