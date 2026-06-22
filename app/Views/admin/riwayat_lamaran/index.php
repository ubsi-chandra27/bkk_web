<?= $this->extend('admin/layout/app') ?>

<?= $this->section('content') ?>
<div id="kt_content_container" class="container-xxl">

    <div class="card shadow-sm mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Riwayat Lamaran</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Pantau riwayat lamaran</span>
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
            <div class="table-responsive">
                <table id="kt_datatable_example_1" class="table table-hover align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="w-10px ps-4">No</th>
                            <th class="min-w-150px">Nama Pelamar</th>
                            <th class="min-w-100px">Posisi</th>
                            <th class="min-w-120px">Perusahaan</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-100px">Catatan</th>
                            <th class="min-w-100px">Diubah Oleh</th>
                            <th class="min-w-100px">Tanggal Diubah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($riwayat)): ?>
                            <?php $no = 1;
                            foreach ($riwayat as $r): ?>
                                <tr>
                                    <td class="text-muted fw-bold fs-6 ps-5"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-bold text-hover-primary text-capitalize">
                                                <?= esc($r['nama_pelamar'] ?? '-') ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">
                                            <?= esc($r['posisi'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">
                                            <?= esc($r['nama_perusahaan'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            <?= $r['status_lama'] ?? '-' ?>
                                        </span>
                                        →
                                        <span class="badge badge-light-primary">
                                            <?= $r['status_baru']; ?>
                                        </span>
                                    </td>
                                    <!-- CATATAN -->
                                    <td><?= $r['catatan'] ?: '-'; ?></td>

                                    <!-- ADMIN -->
                                    <td><?= $r['nama_user'] ?? 'System'; ?></td>

                                    <!-- TANGGAL -->
                                    <td><?= date('d M Y H:i', strtotime($r['created_at'])); ?></td>

                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-10">
                                    <div class="text-gray-600 fs-5 fw-semibold">Belum ada Riwayat Lamaran</div>
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
<?= $this->endSection() ?>