<?= $this->extend('auth/app') ?>
<?php $this->section('content') ?>
<div class="d-flex flex-column flex-root">
    <div class="login-page-bg d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(<?= base_url('assets/media/illustrations/dozzy-1/14.png') ?>)">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <form class="form w-100" method="POST" action="<?= site_url('forgot-password') ?>">
                    <?= csrf_field() ?>

                    <div class="text-center mb-10">
                        <h1 class="text-dark mb-3 fw-bolder">Lupa Password</h1>
                        <div class="text-gray-400 fw-bold fs-4">
                            Masukkan email akun Anda untuk menerima link reset password.
                        </div>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success mb-8">
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mb-8">
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <div class="fv-row mb-8">
                        <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                        <input class="form-control form-control-lg form-control-solid"
                            type="email"
                            name="email"
                            value="<?= esc(old('email')) ?>"
                            autocomplete="email"
                            autofocus
                            required />
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                            Kirim Link Reset
                        </button>
                        <a href="<?= site_url('login') ?>" class="link-primary fw-bolder">
                            Kembali ke login
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex flex-center flex-column-auto p-10">
            <div class="d-flex align-items-center fw-bold fs-6">
                <span class="text-muted">&copy; <?= date('Y') ?> BKK & Tracer Study</span>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>
