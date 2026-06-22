<?= $this->extend('admin/layout/app') ?>
<?= $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">
    <div class="card card-flush mb-4">
        <div class="card-body py-4">
            <form method="GET" action="<?= site_url('admin/data-lowongan') ?>">
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
                        <a href="<?= site_url('admin/data-lowongan') ?>" class="btn btn-light">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data Lowongan</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total <?= count($lowongan) ?> Lowongan</span>
            </h3>

            <!-- ===== Modal Tambah ===== -->
            <div class="modal fade" id="addLowonganModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-750px">
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
                            <form action="<?= site_url('admin/data-lowongan/store') ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Tambah Lowongan Baru</h1>
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
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Posisi</span></label>
                                            <input type="text" class="form-control form-control-solid" name="posisi" placeholder="Contoh: Staff IT" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Gaji</span></label>
                                            <input type="text" class="form-control form-control-solid" id="gaji" name="gaji" placeholder="Rp. 5.000.000" />
                                        </div>
                                        <div class=" d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Jenis Pekerjaan</span></label>
                                            <select class="form-control form-control-solid" name="jenis_pekerjaan" required>
                                                <option value="">-- Pilih Jenis --</option>
                                                <option value="fulltime">Full Time</option>
                                                <option value="parttime">Part Time</option>
                                                <option value="magang">Magang</option>
                                                <option value="kontrak">Kontrak</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2">Lokasi Kerja</label>
                                            <input type="text" class="form-control form-control-solid" name="lokasi_kerja" placeholder="Contoh: Jakarta Selatan" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Batas Lamaran</span></label>
                                            <input type="date" class="form-control form-control-solid" name="batas_lamaran" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Status</span></label>
                                            <select class="form-control form-control-solid" name="status" required>
                                                <option value="draft">Draft</option>
                                                <option value="aktif">Aktif</option>
                                                <option value="ditutup">Ditutup</option>
                                                <option value="kadaluarsa">Kadaluarsa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2">Deskripsi Pekerjaan</label>
                                            <textarea class="form-control form-control-solid" name="deskripsi_pekerjaan" rows="3" placeholder="Tuliskan deskripsi pekerjaan..."></textarea>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2">Kualifikasi</label>
                                            <textarea class="form-control form-control-solid" name="kualifikasi" rows="3" placeholder="Tuliskan kualifikasi..."></textarea>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-3">Jurusan / Keahlian</label>
                                            <div class="d-flex flex-column gap-2">
                                                <?php foreach ($jurusan as $j): ?>
                                                    <label class="d-flex align-items-center gap-2 cursor-pointer">
                                                        <input type="checkbox" class="form-check-input" name="jurusan[]" value="<?= $j['id'] ?>" />
                                                        <span class="fs-6 fw-semibold text-gray-700">
                                                            <?= esc($j['kompetensi_keahlian']) ?>
                                                            <?php if ($j['akronim']): ?>
                                                                <span class="text-muted">(<?= esc($j['akronim']) ?>)</span>
                                                            <?php endif ?>
                                                        </span>
                                                    </label>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-3">Syarat Berkas</label>
                                            <div class="d-flex flex-column gap-2">
                                                <?php foreach ($jenisBerkas as $jb): ?>
                                                    <label class="d-flex align-items-center gap-2 cursor-pointer">
                                                        <input type="checkbox" class="form-check-input" name="jenis_berkas[]" value="<?= $jb['id'] ?>" />
                                                        <span class="fs-6 fw-semibold text-gray-700"><?= esc($jb['nama_berkas']) ?></span>
                                                    </label>
                                                <?php endforeach ?>
                                            </div>
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
            <!-- ===== /Modal Tambah ===== -->

            <!-- ===== Modal Edit ===== -->
            <div class="modal fade" id="editLowonganModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-750px">
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
                            <form id="formEditLowongan" action="" method="POST"
                                data-action-template="<?= site_url('admin/data-lowongan/update/:id') ?>">
                                <?= csrf_field() ?>
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Edit Lowongan</h1>
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
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Posisi</span></label>
                                            <input type="text" class="form-control form-control-solid" name="posisi" id="editPosisi" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Gaji</span></label>
                                            <input type="text" class="form-control form-control-solid" name="gaji" id="editGaji" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Jenis Pekerjaan</span></label>
                                            <select class="form-control form-control-solid" name="jenis_pekerjaan" id="editJenisPekerjaan" required>
                                                <option value="fulltime">Full Time</option>
                                                <option value="parttime">Part Time</option>
                                                <option value="magang">Magang</option>
                                                <option value="kontrak">Kontrak</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2">Lokasi Kerja</label>
                                            <input type="text" class="form-control form-control-solid" name="lokasi_kerja" id="editLokasiKerja" />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Batas Lamaran</span></label>
                                            <input type="date" class="form-control form-control-solid" name="batas_lamaran" id="editBatasLamaran" required />
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2"><span class="required">Status</span></label>
                                            <select class="form-control form-control-solid" name="status" id="editStatus" required>
                                                <option value="draft">Draft</option>
                                                <option value="aktif">Aktif</option>
                                                <option value="ditutup">Ditutup</option>
                                                <option value="kadaluarsa">Kadaluarsa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2">Deskripsi Pekerjaan</label>
                                            <textarea class="form-control form-control-solid" name="deskripsi_pekerjaan" id="editDeskripsi" rows="3"></textarea>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-2">Kualifikasi</label>
                                            <textarea class="form-control form-control-solid" name="kualifikasi" id="editKualifikasi" rows="3"></textarea>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-3">Jurusan / Keahlian</label>
                                            <div class="d-flex flex-column gap-2">
                                                <?php foreach ($jurusan as $j): ?>
                                                    <label class="d-flex align-items-center gap-2 cursor-pointer">
                                                        <input type="checkbox" class="form-check-input edit-jurusan-cb" name="jurusan[]" value="<?= $j['id'] ?>" />
                                                        <span class="fs-6 fw-semibold text-gray-700">
                                                            <?= esc($j['kompetensi_keahlian']) ?>
                                                            <?php if ($j['akronim']): ?>
                                                                <span class="text-muted">(<?= esc($j['akronim']) ?>)</span>
                                                            <?php endif ?>
                                                        </span>
                                                    </label>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="fs-6 fw-semibold mb-3">Syarat Berkas</label>
                                            <div class="d-flex flex-column gap-2">
                                                <?php foreach ($jenisBerkas as $jb): ?>
                                                    <label class="d-flex align-items-center gap-2 cursor-pointer">
                                                        <input type="checkbox" class="form-check-input edit-berkas-cb" name="jenis_berkas[]" value="<?= $jb['id'] ?>" />
                                                        <span class="fs-6 fw-semibold text-gray-700"><?= esc($jb['nama_berkas']) ?></span>
                                                    </label>
                                                <?php endforeach ?>
                                            </div>
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
            <!-- ===== /Modal Edit ===== -->

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
                <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari Lowongan...">
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addLowonganModal">
                    <span class="svg-icon svg-icon-muted svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="black" />
                            <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z" fill="black" />
                        </svg>
                    </span> Tambah Lowongan
                </button>
            </div>
        </div>

        <!-- Tabel -->
        <div class="card-body py-3">
            <div class="table-responsive">
                <table id="kt_datatable_example_1" class="table table-row-dashed table-row-gray-300 table-hover align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="ps-4 w-10px">No</th>
                            <th class="min-w-150px">Perusahaan</th>
                            <th class="min-w-100px">Posisi</th>
                            <th class="min-w-100px">Relevansi Jurusan</th>
                            <th class="min-w-80px">Jenis</th>
                            <th class="min-w-100px">Lokasi</th>
                            <th class="min-w-100px">Batas Lamaran</th>
                            <th class="min-w-150px">Syarat Berkas</th>
                            <th class="min-w-80px">Status</th>
                            <th class="min-w-100px">Dibuat Oleh</th>
                            <th class="text-end pe-4 min-w-80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($lowongan) > 0): ?>
                            <?php $no = 1;
                            foreach ($lowongan as $item): ?>
                                <tr>
                                    <td class="ps-5 text-muted fw-bold"><?= $no++ ?></td>
                                    <td>
                                        <span class="text-dark fw-bold"><?= esc($item['nama_perusahaan'] ?? '-') ?></span>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-bold"><?= esc($item['posisi']) ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($item['id_jurusan'])): ?>
                                            <?php foreach ($item['id_jurusan'] as $idJurusan): ?>
                                                <?php
                                                $jurusanData = array_filter($jurusan, fn($j) => $j['id'] == $idJurusan);
                                                if (!empty($jurusanData)) {
                                                    $jurusanItem = array_shift($jurusanData);
                                                    echo '<span class="badge badge-light-primary">' . esc($jurusanItem['kompetensi_keahlian']) . '</span> ';
                                                }
                                                ?>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif ?>
                                    </td>

                                    <td>
                                        <?php
                                        $jenisBadge = match ($item['jenis_pekerjaan']) {
                                            'fulltime' => 'badge-light-success',
                                            'parttime' => 'badge-light-warning',
                                            'magang'   => 'badge-light-primary',
                                            'kontrak'  => 'badge-light-danger',
                                            default    => 'badge-light'
                                        };
                                        $jenisLabel = match ($item['jenis_pekerjaan']) {
                                            'fulltime' => 'Full Time',
                                            'parttime' => 'Part Time',
                                            'magang'   => 'Magang',
                                            'kontrak'  => 'Kontrak',
                                            default    => '-'
                                        };
                                        ?>
                                        <span class="badge <?= $jenisBadge ?>"><?= $jenisLabel ?></span>
                                    </td>
                                    <td><?= esc($item['lokasi_kerja'] ?? '-') ?></td>
                                    <td><?= $item['batas_lamaran'] ?? '-' ?></td>
                                    <td>
                                        <?php if (!empty($item['syarat_berkas'])): ?>
                                            <?php foreach ($item['syarat_berkas'] as $syarat): ?>
                                                <span class="badge badge-light-dark mb-1"><?= esc($syarat['nama_berkas']) ?></span>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php
                                        $statusBadge = match ($item['status']) {
                                            'aktif'      => 'badge-success',
                                            'draft'      => 'badge-warning',
                                            'ditutup'    => 'badge-danger',
                                            'kadaluarsa' => 'badge-secondary',
                                            default      => 'badge-light'
                                        };
                                        ?>
                                        <span class="badge <?= $statusBadge ?>"><?= ucfirst($item['status']) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light text-dark fs-7 fw-semibold">
                                            <?= esc($item['dibuat_oleh_nama'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex justify-content-end flex-nowrap gap-2 align-items-center">
                                            <a href="<?= site_url('admin/data-lowongan/show/' . $item['id']) ?>"
                                                class="btn btn-icon btn-bg-light btn-active-color-info btn-sm"
                                                title="Detail">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M12 5C7 5 2.73 8.11 1 12C2.73 15.89 7 19 12 19C17 19 21.27 15.89 23 12C21.27 8.11 17 5 12 5ZM12 17C8.69 17 5.84 14.93 4.68 12C5.84 9.07 8.69 7 12 7C15.31 7 18.16 9.07 19.32 12C18.16 14.93 15.31 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <button type="button"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editLowonganModal"
                                                data-id="<?= $item['id'] ?>"
                                                data-id_perusahaan="<?= $item['id_perusahaan'] ?>"
                                                data-posisi="<?= esc($item['posisi']) ?>"
                                                data-gaji="<?= esc($item['gaji']) ?>"
                                                data-jenis_pekerjaan="<?= $item['jenis_pekerjaan'] ?>"
                                                data-lokasi_kerja="<?= esc($item['lokasi_kerja'] ?? '') ?>"
                                                data-batas_lamaran="<?= $item['batas_lamaran'] ?? '' ?>"
                                                data-status="<?= $item['status'] ?>"
                                                data-deskripsi="<?= esc($item['deskripsi_pekerjaan'] ?? '') ?>"
                                                data-kualifikasi="<?= esc($item['kualifikasi'] ?? '') ?>"
                                                data-jurusan="<?= esc(json_encode($item['id_jurusan'] ?? [])) ?>"
                                                data-jenis_berkas="<?= esc(json_encode($item['id_jenis_berkas'] ?? [])) ?>"
                                                title="Edit">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </button>
                                            <a href="<?= site_url('admin/data-lowongan/delete/' . $item['id']) ?>"
                                                class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-btn"
                                                data-title="Hapus Lowongan"
                                                data-text="Anda akan menghapus lowongan &quot;<?= esc($item['posisi']) ?>&quot;. Tindakan ini tidak dapat dibatalkan!"
                                                title="Hapus">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center py-10">
                                    <div class="text-gray-600 fs-5 fw-semibold">Belum ada data Lowongan</div>
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

    $(document).on('click', '[data-bs-target="#editLowonganModal"]', function() {
        const btn = $(this);
        const form = $('#formEditLowongan');

        $('#editIdPerusahaan').val(btn.data('id_perusahaan'));
        $('#editPosisi').val(btn.data('posisi'));
        $('#editGaji').val(btn.data('gaji'));
        $('#editJenisPekerjaan').val(btn.data('jenis_pekerjaan'));
        $('#editLokasiKerja').val(btn.data('lokasi_kerja'));
        $('#editBatasLamaran').val(btn.data('batas_lamaran'));
        $('#editStatus').val(btn.data('status'));
        $('#editDeskripsi').val(btn.data('deskripsi'));
        $('#editKualifikasi').val(btn.data('kualifikasi'));

        // Set checkbox jurusan
        const selectedJurusan = btn.data('jurusan') || [];
        $('.edit-jurusan-cb').each(function() {
            $(this).prop('checked', selectedJurusan.includes(parseInt($(this).val())));
        });

        const selectedBerkas = btn.data('jenis_berkas') || [];
        $('.edit-berkas-cb').each(function() {
            $(this).prop('checked', selectedBerkas.includes(parseInt($(this).val())));
        });

        const actionTemplate = form.data('action-template');
        form.attr('action', actionTemplate.replace(':id', btn.data('id')));
    });
    document.addEventListener('DOMContentLoaded', function() {

        const input = document.getElementById('gaji');
        if (!input) return;

        function formatRupiah(angka) {
            // ambil hanya angka
            let number_string = angka.replace(/[^,\d]/g, '').toString();

            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah ? 'Rp ' + rupiah : '';
        }

        input.addEventListener('input', function(e) {
            input.value = formatRupiah(this.value);
        });

    });
    document.addEventListener('DOMContentLoaded', function() {

        const input = document.getElementById('editGaji');
        if (!input) return;

        function formatRupiah(angka) {
            // ambil hanya angka
            let number_string = angka.replace(/[^,\d]/g, '').toString();

            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah ? 'Rp ' + rupiah : '';
        }

        input.addEventListener('input', function(e) {
            input.value = formatRupiah(this.value);
        });

    });
</script>
<?php $this->endSection() ?>
