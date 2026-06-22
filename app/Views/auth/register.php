<?= $this->extend('auth/app') ?>
<?php $this->section('content') ?>
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-up -->
    <div class="login-page-bg d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/dozzy-1/14.png)">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Wrapper-->
            <div class="w-lg-800px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
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

                    <?php $isAlumni = old('role') === 'pelamar_alumni'; ?>
                    <div id="alumni_fields" class="<?= $isAlumni ? '' : 'd-none' ?>">
                        <div class="row g-6 mb-7">
                            <div class="col-md-6">
                                <label class="form-label fs-6 fw-bolder text-dark">Jurusan</label>
                                <select class="form-control form-control-lg form-control-solid alumni-required"
                                    name="id_jurusan"
                                    <?= $isAlumni ? 'required' : '' ?>>
                                    <option value="">Pilih jurusan</option>
                                    <?php foreach (($jurusans ?? []) as $jurusan): ?>
                                        <option value="<?= esc($jurusan['id']) ?>" <?= old('id_jurusan') == $jurusan['id'] ? 'selected' : '' ?>>
                                            <?= esc($jurusan['kompetensi_keahlian']) ?><?= !empty($jurusan['akronim']) ? ' (' . esc($jurusan['akronim']) . ')' : '' ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fs-6 fw-bolder text-dark">Angkatan</label>
                                <select class="form-control form-control-lg form-control-solid alumni-required"
                                    name="id_angkatan"
                                    <?= $isAlumni ? 'required' : '' ?>>
                                    <option value="">Pilih angkatan</option>
                                    <?php foreach (($angkatans ?? []) as $angkatan): ?>
                                        <option value="<?= esc($angkatan['id']) ?>" <?= old('id_angkatan') == $angkatan['id'] ? 'selected' : '' ?>>
                                            <?= esc($angkatan['tahun']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fs-6 fw-bolder text-dark">NIS</label>
                                <input class="form-control form-control-lg form-control-solid alumni-required"
                                    type="text"
                                    name="nis"
                                    value="<?= esc(old('nis')) ?>"
                                    autocomplete="off"
                                    <?= $isAlumni ? 'required' : '' ?> />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fs-6 fw-bolder text-dark">NISN</label>
                                <input class="form-control form-control-lg form-control-solid alumni-required"
                                    type="text"
                                    name="nisn"
                                    value="<?= esc(old('nisn')) ?>"
                                    autocomplete="off"
                                    <?= $isAlumni ? 'required' : '' ?> />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fs-6 fw-bolder text-dark">No Ijazah</label>
                                <input class="form-control form-control-lg form-control-solid alumni-required"
                                    type="text"
                                    name="no_ijazah"
                                    value="<?= esc(old('no_ijazah')) ?>"
                                    autocomplete="off"
                                    <?= $isAlumni ? 'required' : '' ?> />
                            </div>
                        </div>
                    </div>

                    <!--begin::Input group-->
                    <div class="fv-row mb-7" data-kt-password-meter="true">
                        <div class="d-flex flex-stack mb-2">
                            <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                        </div>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-lg form-control-solid"
                                type="password"
                                name="password"
                                id="registerPassword"
                                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
                                title="Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol."
                                autocomplete="off"
                                required />
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                        </div>
                        <div class="password-strength-meter">
                            <div class="strength-bar">
                                <div class="strength-progress" id="strengthProgress"></div>
                            </div>
                            <div class="strength-text mt-2" id="strengthText">Kekuatan password: <span class="text-muted">Belum diisi</span></div>
                            <ul class="password-requirements list-unstyled mt-2">
                                <li id="req-length" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Minimal 8 karakter</li>
                                <li id="req-uppercase" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung huruf besar (A-Z)</li>
                                <li id="req-lowercase" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung huruf kecil (a-z)</li>
                                <li id="req-number" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung angka (0-9)</li>
                                <li id="req-symbol" class="text-muted fs-7"><i class="bi bi-x-circle me-1"></i> Mengandung karakter simbol (!@#$%^&* dll)</li>
                            </ul>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const alumniFields = document.getElementById('alumni_fields');
    const roleInputs = document.querySelectorAll('input[name="role"]');
    const requiredInputs = document.querySelectorAll('.alumni-required');

    function syncAlumniFields() {
        const selectedRole = document.querySelector('input[name="role"]:checked');
        const isAlumni = selectedRole && selectedRole.value === 'pelamar_alumni';

        alumniFields.classList.toggle('d-none', !isAlumni);
        requiredInputs.forEach(function (input) {
            input.required = isAlumni;
        });
    }

    roleInputs.forEach(function (input) {
        input.addEventListener('change', syncAlumniFields);
    });
    syncAlumniFields();
});

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

initPasswordMeter('registerPassword', 'strengthProgress', 'strengthText', [
    'req-length', 'req-uppercase', 'req-lowercase', 'req-number', 'req-symbol'
]);
</script>
<?php $this->endSection() ?>
