<?= $this->extend('auth/app') ?>
<?php $this->section('content') ?>
<div class="d-flex flex-column flex-root">
    <div class="login-page-bg d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(<?= base_url('assets/media/illustrations/dozzy-1/14.png') ?>)">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <form class="form w-100" method="POST" action="<?= site_url('reset-password/' . $token) ?>">
                    <?= csrf_field() ?>

                    <div class="text-center mb-10">
                        <h1 class="text-dark mb-3 fw-bolder">Reset Password</h1>
                        <div class="text-gray-400 fw-bold fs-4">
                            Buat password baru yang kuat.
                        </div>
                    </div>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger mb-8">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <div><?= esc($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mb-8">
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <div class="fv-row mb-8" data-kt-password-meter="true">
                        <label class="form-label fs-6 fw-bolder text-dark">Password Baru</label>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-lg form-control-solid"
                                type="password"
                                name="password"
                                id="resetPassword"
                                value="<?= esc(old('password')) ?>"
                                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
                                title="Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol."
                                autocomplete="new-password"
                                required />
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                        </div>
                        <div class="password-strength-meter">
                            <div class="strength-bar">
                                <div class="strength-progress" id="strengthProgressReset"></div>
                            </div>
                            <div class="strength-text mt-2" id="strengthTextReset">Kekuatan password: <span class="text-muted">Belum diisi</span></div>
                            <ul class="password-requirements list-unstyled mt-2">
                                <li id="req-length-reset" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Minimal 8 karakter</li>
                                <li id="req-uppercase-reset" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung huruf besar (A-Z)</li>
                                <li id="req-lowercase-reset" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung huruf kecil (a-z)</li>
                                <li id="req-number-reset" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung angka (0-9)</li>
                                <li id="req-symbol-reset" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung karakter simbol (!@#$%^&* dll)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="fv-row mb-8">
                        <label class="form-label fs-6 fw-bolder text-dark">Konfirmasi Password</label>
                        <input class="form-control form-control-lg form-control-solid"
                            type="password"
                            name="confirm_password"
                            value="<?= esc(old('confirm_password')) ?>"
                            autocomplete="new-password"
                            required />
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                            Simpan Password Baru
                        </button>
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
<style>
.password-strength-meter {
    margin-top: 10px;
}
.strength-bar {
    height: 6px;
    background-color: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}
.strength-progress {
    height: 100%;
    width: 0%;
    transition: width 0.3s ease, background-color 0.3s ease;
}
.strength-text .text-success { color: #50cd89; }
.strength-text .text-warning { color: #ffc107; }
.strength-text .text-danger { color: #f1416c; }
.password-requirements li {
    transition: color 0.3s ease;
}
.password-requirements li.text-success {
    color: #50cd89 !important;
}
</style>
<?php $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function initPasswordMeter(inputId, progressId, textId, reqIds) {
    const input = document.getElementById(inputId);
    if (!input) return;

    const progress = document.getElementById(progressId);
    const textEl = document.getElementById(textId);

    input.addEventListener('input', function () {
        const password = this.value;
        let score = 0;

        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        const widths = [0, 20, 40, 60, 80, 100];
        const colors = ['#e9ecef', '#f1416c', '#f1416c', '#ffc107', '#ffc107', '#50cd89'];
        const labels = ['Belum diisi', 'Lemah', 'Lemah', 'Sedang', 'Sedang', 'Kuat'];
        const labelClasses = ['text-muted', 'text-danger', 'text-danger', 'text-warning', 'text-warning', 'text-success'];

        progress.style.width = widths[score] + '%';
        progress.style.backgroundColor = colors[score];

        textEl.innerHTML = 'Kekuatan password: <span class="' + labelClasses[score] + '">' + labels[score] + '</span>';

        reqIds.forEach(function (id) {
            const el = document.getElementById(id);
            if (!el) return;

            let met = false;
            if (id.includes('length') && password.length >= 8) met = true;
            else if (id.includes('uppercase') && /[A-Z]/.test(password)) met = true;
            else if (id.includes('lowercase') && /[a-z]/.test(password)) met = true;
            else if (id.includes('number') && /[0-9]/.test(password)) met = true;
            else if (id.includes('symbol') && /[^A-Za-z0-9]/.test(password)) met = true;

            if (met) {
                el.classList.remove('text-muted');
                el.classList.add('text-success');
                el.querySelector('i').className = 'bi bi-check-circle me-1';
            } else {
                el.classList.remove('text-success');
                el.classList.add('text-muted');
                el.querySelector('i').className = 'bi bi-x-circle me-1';
            }
        });
    });
}

initPasswordMeter('resetPassword', 'strengthProgressReset', 'strengthTextReset', [
    'req-length-reset', 'req-uppercase-reset', 'req-lowercase-reset', 'req-number-reset', 'req-symbol-reset'
]);
</script>
<?php $this->endSection() ?>
