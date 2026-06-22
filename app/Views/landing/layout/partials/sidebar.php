<?php
$session    = session();
$isLoggedIn = $session->has('user_id');
$userRole   = $session->get('role') ?? '';
$userName   = $session->get('nama') ?? '';
$userAvatar = $session->get('avatar')
    ? base_url('uploads/' . $session->get('avatar'))
    : base_url('assets/media/avatars/blank.png');

function isActiveSidebar(string $path): bool
{
    return str_starts_with(current_url(), site_url($path));
}
?>

<!--begin::Mobile Sidebar-->
<div id="kt_landing_menu_mobile"
    class="menu menu-column menu-gray-600 menu-state-bg-light-primary menu-hover-primary fw-semibold fs-6 w-225px py-4"
    data-kt-drawer="true"
    data-kt-drawer-name="landing-menu"
    data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="225px"
    data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_landing_menu_toggle"
    data-kt-menu="true">

    <?php if ($isLoggedIn): ?>
        <!-- User mini card -->
        <div class="menu-item px-4 pb-4">
            <div class="d-flex align-items-center p-3 bg-light rounded">
                <div class="symbol symbol-35px me-3">
                    <img src="<?= esc($userAvatar) ?>" alt="avatar" />
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold text-gray-800 text-capitalize"><?= esc($userName) ?></div>
                    <div class="text-muted fs-8 text-capitalize"><?= esc(str_replace('_', ' ', $userRole)) ?></div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Beranda -->
    <div class="menu-item">
        <a class="menu-link py-3 px-4 <?= (current_url() === site_url('/') || isActiveSidebar('beranda')) ? 'active' : '' ?>"
            href="<?= site_url('/') ?>"
            data-kt-drawer-dismiss="true">
            <span class="menu-icon"><i class="fa-solid fa-house fs-5"></i></span>
            <span class="menu-title">Beranda</span>
        </a>
    </div>

    <!-- Lowongan Kerja -->
    <div class="menu-item">
        <a class="menu-link py-3 px-4 <?= isActiveSidebar('lowongan') ? 'active' : '' ?>"
            href="<?= site_url('lowongan') ?>"
            data-kt-drawer-dismiss="true">
            <span class="menu-icon"><i class="fa-solid fa-briefcase fs-5"></i></span>
            <span class="menu-title">Lowongan Kerja</span>
        </a>
    </div>

    <!-- Informasi (accordion) -->
    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
        <span class="menu-link py-3 px-4">
            <span class="menu-icon"><i class="fa-solid fa-circle-info fs-5"></i></span>
            <span class="menu-title">Informasi</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion">
            <div class="menu-item">
                <a href="<?= site_url('tracer-alumni') ?>"
                    class="menu-link py-2 px-6 <?= isActiveSidebar('tracer-alumni') ? 'active' : '' ?>"
                    data-kt-drawer-dismiss="true">
                    <span class="menu-icon me-2"><i class="fa-solid fa-graduation-cap fs-6"></i></span>
                    <span class="menu-title">Tracer Alumni</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="<?= site_url('perusahaan') ?>"
                    class="menu-link py-2 px-6 <?= isActiveSidebar('perusahaan') ? 'active' : '' ?>"
                    data-kt-drawer-dismiss="true">
                    <span class="menu-icon me-2"><i class="fa-solid fa-building fs-6"></i></span>
                    <span class="menu-title">Perusahaan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Section Akun -->
    <div class="menu-content px-4 pt-2 pb-1 text-muted text-uppercase fs-8">Akun</div>

    <?php if (!$isLoggedIn): ?>
        <div class="menu-item">
            <a class="menu-link py-3 px-4" href="<?= site_url('login') ?>" data-kt-drawer-dismiss="true">
                <span class="menu-icon"><i class="fa-solid fa-right-to-bracket fs-5"></i></span>
                <span class="menu-title">Masuk</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link py-3 px-4" href="<?= site_url('register') ?>" data-kt-drawer-dismiss="true">
                <span class="menu-icon"><i class="fa-regular fa-id-badge fs-5"></i></span>
                <span class="menu-title">Daftar</span>
            </a>
        </div>
    <?php else: ?>
        <div class="menu-item">
            <form action="<?= site_url('logout') ?>" method="POST" class="w-100">
                <?= csrf_field() ?>
                <button type="submit" class="menu-link w-100 py-3 px-4 btn btn-link text-start">
                    <span class="menu-icon"><i class="fa-solid fa-arrow-right-from-bracket fs-5"></i></span>
                    <span class="menu-title">Keluar</span>
                </button>
            </form>
        </div>
    <?php endif; ?>

    <div class="menu-content px-4 pt-4">
        <div class="text-muted fs-8">BKK & Tracer Study</div>
    </div>

</div>
<!--end::Mobile Sidebar-->