<?= $this->extend('admin/layout/app') ?>

<?= $this->section('content') ?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row gy-5 gx-xl-8">
        <!--begin::Col-->
        <div class="col-12">
            <!--begin::Mixed Widget 2-->
            <div class="card card-xxl-stretch">
                <!--begin::Header-->
                <div class="card-header border-0 bg-primary py-5">
                    <h3 class="card-title fw-bolder text-white">Dashboard Admin</h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body p-0">
                    <!--begin::Chart-->
                    <div class="mixed-widget-2-chart card-rounded-bottom bg-primary" data-kt-color="primary" style="height: 180px"></div>
                    <!--end::Chart-->
                    <!--begin::Row Statistics-->
                    <div class="card-p shadow-sm mt-n15 mt-md-n20 position-relative px-4 px-md-6 pb-6">
                        <div class="row g-5">
                            <div class="col-12 col-sm-6 col-xl-3">
                                <!--begin::Statistics Widget 5-->
                                <a href="<?= base_url('admin/data-tracer') ?>" class="card shadow-sm bg-light-dark hoverable h-100">
                                    <!--begin::Body-->
                                    <div class="card-body p-5 p-lg-7">
                                        <i class="fa-solid fa-user-graduate fa-2x text-dark"></i>
                                        <div class="text-dark fw-bolder fs-2hx mb-2 mt-5"><?= $totalAlumni ?></div>
                                        <div class="fw-bold text-gray-400">Total Alumni</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                                <!--end::Statistics Widget 5-->
                            </div>
                            <div class="col-12 col-sm-6 col-xl-3">
                                <!--begin::Statistics Widget 5-->
                                <a href="<?= base_url('admin/data-perusahaan') ?>" class="card shadow-sm bg-light-dark hoverable h-100">
                                    <!--begin::Body-->
                                    <div class="card-body p-5 p-lg-7">
                                        <i class="fa-solid fa-building fa-2x text-dark"></i>
                                        <div class="text-dark fw-bolder fs-2hx mb-2 mt-5"><?= $totalPerusahaan ?></div>
                                        <div class="fw-bold text-gray-400">Total Perusahaan Mitra</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                                <!--end::Statistics Widget 5-->
                            </div>
                            <div class="col-12 col-sm-6 col-xl-3">
                                <!--begin::Statistics Widget 5-->
                                <a href="<?= base_url('admin/data-lowongan') ?>" class="card shadow-sm bg-light-dark hoverable h-100">
                                    <!--begin::Body-->
                                    <div class="card-body p-5 p-lg-7">
                                        <i class="fa-solid fa-briefcase fa-2x text-dark"></i>
                                        <div class="text-dark fw-bolder fs-2hx mb-2 mt-5"><?= $totalLowongan ?></div>
                                        <div class="fw-bold text-gray-400">Total Lowongan Kerja</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                                <!--end::Statistics Widget 5-->
                            </div>
                            <div class="col-12 col-sm-6 col-xl-3">
                                <!--begin::Statistics Widget 5-->
                                <a href="<?= base_url('admin/data-pelamar') ?>" class="card shadow-sm bg-light-dark hoverable h-100">
                                    <!--begin::Body-->
                                    <div class="card-body p-5 p-lg-7">
                                        <i class="fa-solid fa-user-group fa-2x text-dark"></i>
                                        <div class="text-dark fw-bolder fs-2hx mb-2 mt-5"><?= $totalPelamar ?></div>
                                        <div class="fw-bold text-gray-400">Total Pelamar</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                                <!--end::Statistics Widget 5-->
                            </div>
                        </div>
                        <!--end::Row Statistics-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 2-->
            </div>
        </div>
        <!--end::Col-->
    </div>
</div>
<!--end::Container-->
<?= $this->endSection() ?>
