<?= $this->extend('auth/app') ?>
<?php $this->section('content') ?>
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-up -->
    <div class="login-page-bg d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/dozzy-1/14.png)">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Wrapper-->
            <div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <form class="form w-100" method="POST" action="<?= site_url('register') ?>" id="kt_sign_up_form">
                    <?= csrf_field() ?>
                    <!--begin::Heading-->
                    <div class="mb-10 text-center">
                        <h1 class="text-dark mb-3">Daftar Akun Baru</h1>
                        <div class="text-gray-400 fw-bold fs-4">Sudah punya akun?
                            <a href="<?= site_url('login') ?>" class="link-primary fw-bolder">Masuk di sini</a>
                        </div>
                    </div>
                    <!--end::Heading-->
                    <!--begin::Separator-->
                    <div class="d-flex align-items-center mb-10">
                        <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                        <span class="fw-bold text-gray-400 fs-7 mx-2"></span>
                        <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                    </div>
                    <!--end::Separator-->

                    <!--begin::Alert-->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                            <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <div class="d-flex flex-column">
                                <span><?= session()->getFlashdata('error') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                            <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <div class="d-flex flex-column">
                                <span><?= session()->getFlashdata('success') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!--end::Alert-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fs-6 fw-bolder text-dark">Nama Lengkap</label>
                        <input class="form-control form-control-lg form-control-solid"
                            type="text"
                            name="nama"
                            value="<?= old('nama') ?>"
                            autocomplete="off"
                            required />
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                        <input class="form-control form-control-lg form-control-solid"
                            type="email"
                            name="email"
                            value="<?= old('email') ?>"
                            autocomplete="email"
                            required />
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fs-6 fw-bolder text-dark">Jenis Akun</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input" type="radio" name="role" value="pelamar_alumni" id="pelamar_alumni" <?= old('role') == 'pelamar_alumni' ? 'checked' : '' ?> />
                                    <label class="form-check-label fw-semibold text-gray-700" for="pelamar_alumni">
                                        Pelamar Alumni
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input" type="radio" name="role" value="pelamar_umum" id="pelamar_umum" <?= old('role') == 'pelamar_umum' ? 'checked' : '' ?> />
                                    <label class="form-check-label fw-semibold text-gray-700" for="pelamar_umum">
                                        Pelamar Umum
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7" data-kt-password-meter="true">
                        <div class="d-flex flex-stack mb-2">
                            <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                        </div>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-lg form-control-solid"
                                type="password"
                                name="password"
                                autocomplete="off"
                                required />
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fs-6 fw-bolder text-dark">Konfirmasi Password</label>
                        <input class="form-control form-control-lg form-control-solid"
                            type="password"
                            name="password_confirmation"
                            autocomplete="off"
                            required />
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <label class="form-check form-check-custom form-check-solid form-check-inline">
                            <input class="form-check-input" type="checkbox" name="terms" value="1" />
                            <span class="form-check-label fw-bold text-gray-700 fs-6">Saya menyetujui
                                <a href="#" class="link-primary">Syarat dan Ketentuan</a>.</span>
                        </label>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-primary w-100 mb-5">
                            <span class="indicator-label">Daftar</span>
                            <span class="indicator-progress">Mohon tunggu...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->

        <!--begin::Footer-->
        <div class="d-flex flex-center flex-column-auto p-10">
            <div class="d-flex align-items-center fw-bold fs-6">
                <span class="text-muted">&copy; <?= date('Y') ?> BKK & Tracer Study</span>
            </div>
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Authentication - Sign-up-->
</div>
<!--end::Main-->
<?php $this->endSection() ?>