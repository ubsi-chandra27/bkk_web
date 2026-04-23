<?= $this->extend('admin/layout/app') ?>
<?php $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data MOU</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total <?= count($mous) ?> MOU terdaftar</span>
            </h3>

            <!-- ===== Modal Tambah MOU ===== -->
            <div class="modal fade" id="addMouModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content rounded">
                        <div class="modal-header pb-0 border-0 justify-content-end">
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <span class="svg-icon svg-icon-1">✕</span>
                            </div>
                        </div>
                        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                            <form action="<?= site_url('admin/data-mou/store') ?>" method="POST" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Tambah MOU Baru</h1>
                                </div>
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="alert alert-danger p-5 mb-8">
                                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                            <div>&bull; <?= esc($error) ?></div>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                                <div class="row g-3 mb-8">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Perusahaan</span></label>
                                            <select class="form-control form-control-solid" name="id_perusahaan" required>
                                                <option value="">-- Pilih Perusahaan --</option>
                                                <?php foreach ($perusahaan as $p): ?>
                                                    <option value="<?= $p['id'] ?>"><?= esc($p['nama_perusahaan']) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Jenis Kerjasama</span></label>
                                            <select class="form-control form-control-solid" name="id_kerjasama" required>
                                                <option value="">-- Pilih Kerjasama --</option>
                                                <?php foreach ($kerjasama as $k): ?>
                                                    <option value="<?= $k['id'] ?>"><?= esc($k['nama_kerjasama']) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Nomor MOU</span></label>
                                            <input type="text" class="form-control form-control-solid" name="nomor_mou" placeholder="Contoh: MOU/2024/001" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Status</span></label>
                                            <select class="form-control form-control-solid" name="status" required>
                                                <option value="aktif">Aktif</option>
                                                <option value="berakhir">Berakhir</option>
                                                <option value="diperpanjang">Diperpanjang</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Tanggal MOU</span></label>
                                            <input type="date" class="form-control form-control-solid" name="tanggal_mou" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Tanggal Berlaku</span></label>
                                            <input type="date" class="form-control form-control-solid" name="tanggal_berlaku" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Tanggal Berakhir</span></label>
                                            <input type="date" class="form-control form-control-solid" name="tanggal_berakhir" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2">File MOU (PDF/Gambar)</label>
                                            <input type="file" class="form-control form-control-solid" name="file_mou" accept=".pdf,.jpg,.jpeg,.png" />
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ===== /Modal Tambah MOU ===== -->

            <!-- ===== Modal Edit MOU ===== -->
            <div class="modal fade" id="editMouModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content rounded">
                        <div class="modal-header pb-0 border-0 justify-content-end">
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <span class="svg-icon svg-icon-1">✕</span>
                            </div>
                        </div>
                        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                            <form id="formEditMou" action="" method="POST" enctype="multipart/form-data"
                                data-action-template="<?= site_url('admin/data-mou/update/:id') ?>">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Edit MOU</h1>
                                </div>
                                <div class="row g-3 mb-8">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Perusahaan</span></label>
                                            <select class="form-control form-control-solid" name="id_perusahaan" id="editIdPerusahaan" required>
                                                <option value="">-- Pilih Perusahaan --</option>
                                                <?php foreach ($perusahaan as $p): ?>
                                                    <option value="<?= $p['id'] ?>"><?= esc($p['nama_perusahaan']) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Jenis Kerjasama</span></label>
                                            <select class="form-control form-control-solid" name="id_kerjasama" id="editIdKerjasama" required>
                                                <option value="">-- Pilih Kerjasama --</option>
                                                <?php foreach ($kerjasama as $k): ?>
                                                    <option value="<?= $k['id'] ?>"><?= esc($k['nama_kerjasama']) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Nomor MOU</span></label>
                                            <input type="text" class="form-control form-control-solid" name="nomor_mou" id="editNomorMou" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Status</span></label>
                                            <select class="form-control form-control-solid" name="status" id="editStatus" required>
                                                <option value="aktif">Aktif</option>
                                                <option value="berakhir">Berakhir</option>
                                                <option value="diperpanjang">Diperpanjang</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Tanggal MOU</span></label>
                                            <input type="date" class="form-control form-control-solid" name="tanggal_mou" id="editTanggalMou" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Tanggal Berlaku</span></label>
                                            <input type="date" class="form-control form-control-solid" name="tanggal_berlaku" id="editTanggalBerlaku" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Tanggal Berakhir</span></label>
                                            <input type="date" class="form-control form-control-solid" name="tanggal_berakhir" id="editTanggalBerakhir" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2">File MOU Baru (opsional)</label>
                                            <input type="file" class="form-control form-control-solid" name="file_mou" accept=".pdf,.jpg,.jpeg,.png" />
                                            <div class="form-text text-muted fs-7" id="editFileLama"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ===== /Modal Edit MOU ===== -->

        </div>

        <!-- Search & Tambah -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-3 px-5 px-md-8">
            <div class="position-relative w-100 w-md-auto">
                <span class="svg-icon svg-icon-1 position-absolute translate-middle-y top-50 ms-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                    </svg>
                </span>
                <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari MOU...">
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addMouModal">
                    + Tambah MOU
                </button>
            </div>
        </div>

        <!-- Tabel -->
        <div class="card-body py-3">
            <div class="table-responsive">
                <table id="kt_datatable_mou" class="table table-hover align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="ps-4">No</th>
                            <th class="min-w-100px">Nomor MOU</th>
                            <th class="min-w-100px">Perusahaan</th>
                            <th class="min-w-100px">Jenis Kerjasama</th>
                            <th class="min-w-100px">Tgl MOU</th>
                            <th class="min-w-100px">Tgl Berakhir</th>
                            <th class="min-w-50px">Status</th>
                            <th class="min-w-50px">File</th>
                            <th class="text-end pe-4 min-w-50px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($mous) > 0): ?>
                            <?php $no = 1;
                            foreach ($mous as $item): ?>
                                <tr>
                                    <td class="ps-5 text-muted fw-bold"><?= $no++ ?></td>
                                    <td class="fw-bold"><?= esc($item['nomor_mou']) ?></td>
                                    <td><?= esc($item['nama_perusahaan'] ?? '-') ?></td>
                                    <td><?= esc($item['nama_kerjasama'] ?? '-') ?></td>
                                    <td><?= $item['tanggal_mou'] ?? '-' ?></td>
                                    <td><?= $item['tanggal_berakhir'] ?? '-' ?></td>
                                    <td>
                                        <?php
                                        $status = $item['status'] ?? 'aktif';
                                        $badge = match ($status) {
                                            'aktif'       => 'badge-success',
                                            'berakhir'    => 'badge-danger',
                                            'diperpanjang' => 'badge-warning',
                                            default       => 'badge-light'
                                        };
                                        ?>
                                        <span class="badge <?= $badge ?>"><?= ucfirst($status) ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($item['file_mou'])): ?>
                                            <a href="<?= base_url('uploads/mou/' . $item['file_mou']) ?>" target="_blank" class="btn btn-sm btn-light-primary">
                                                Lihat File
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button type="button"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editMouModal"
                                            data-id="<?= $item['id'] ?>"
                                            data-id_perusahaan="<?= $item['id_perusahaan'] ?>"
                                            data-id_kerjasama="<?= $item['id_kerjasama'] ?>"
                                            data-nomor_mou="<?= esc($item['nomor_mou']) ?>"
                                            data-tanggal_mou="<?= $item['tanggal_mou'] ?>"
                                            data-tanggal_berlaku="<?= $item['tanggal_berlaku'] ?>"
                                            data-tanggal_berakhir="<?= $item['tanggal_berakhir'] ?>"
                                            data-status="<?= $item['status'] ?>"
                                            data-file_mou="<?= $item['file_mou'] ?? '' ?>"
                                            title="Edit">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 7.45335 21.9962 7.97122 21.7817 8.35303 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                        <a href="<?= site_url('admin/data-mou/delete/' . $item['id']) ?>"
                                            class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-btn"
                                            data-title="Hapus MOU"
                                            data-text="Anda akan menghapus MOU &quot;<?= esc($item['nomor_mou']) ?>&quot;. Tindakan ini tidak dapat dibatalkan!"
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
                                    <div class="text-gray-600 fs-5 fw-semibold">Belum ada data MOU</div>
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
        const $dataTable = $('#kt_datatable_mou').DataTable();
        $('#searchInput').on('keyup', function() {
            $dataTable.search(this.value).draw();
        });
    });

    $(document).on('click', '[data-bs-target="#editMouModal"]', function() {
        const btn = $(this);
        const form = $('#formEditMou');

        const id = btn.data('id');
        $('#editIdPerusahaan').val(btn.data('id_perusahaan'));
        $('#editIdKerjasama').val(btn.data('id_kerjasama'));
        $('#editNomorMou').val(btn.data('nomor_mou'));
        $('#editTanggalMou').val(btn.data('tanggal_mou'));
        $('#editTanggalBerlaku').val(btn.data('tanggal_berlaku'));
        $('#editTanggalBerakhir').val(btn.data('tanggal_berakhir'));
        $('#editStatus').val(btn.data('status'));

        const fileLama = btn.data('file_mou');
        $('#editFileLama').text(fileLama ? 'File saat ini: ' + fileLama : 'Belum ada file');

        const actionTemplate = form.data('action-template');
        form.attr('action', actionTemplate.replace(':id', id));
    });
</script>
<?php $this->endSection() ?>