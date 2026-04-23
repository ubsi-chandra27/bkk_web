<?php
$uri        = service('uri');
$currentUrl = current_url();

function isActive(string $routeName): bool
{
    return current_url() === site_url($routeName)
        || str_starts_with(current_url(), site_url($routeName . '/'));
}

$session    = session();

$isLoggedIn = $session->get('isLoggedIn') ?? false;
$userRole   = $session->get('id_role') ?? '';
$userName   = $session->get('nama') ?? 'User';
$userEmail  = $session->get('email') ?? '';

$userAvatar = $session->get('foto')
    ? base_url('uploads/foto/' . $session->get('foto'))
    : base_url('assets/media/avatars/blank.png');
?>

<!--begin::Header Section-->
<div class="mb-0" id="home">
    <div class="bgi-no-repeat bgi-size-cover bgi-position-x-center bgi-position-y-bottom"
        style="background-image: linear-gradient(rgba(19,38,60,0.45), rgba(19,38,60,0.45)),
                url('<?= base_url('assets/media/illustrations/gemini.png') ?>');">

        <!--begin::Sticky Header-->
        <div class="landing-header"
            data-kt-sticky="true"
            data-kt-sticky-name="landing-header"
            data-kt-sticky-offset='{"default":"200px","lg":"300px"}'>
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">

                    <!--begin::Logo-->
                    <div class="d-flex align-items-center flex-equal">
                        <!-- Mobile toggle -->
                        <button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none"
                            id="kt_landing_menu_toggle">
                            <span class="svg-icon svg-icon-2hx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
                                    <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
                                </svg>
                            </span>
                        </button>

                        <a href="<?= site_url('/') ?>" class="d-flex align-items-center text-decoration-none">
                            <img alt="Logo BKK" src="<?= base_url('assets/media/logos/tp4.png') ?>"
                                class="logo-default h-40px h-lg-50px me-3" />
                            <img alt="Logo BKK" src="<?= base_url('assets/media/logos/tp4.png') ?>"
                                class="logo-sticky h-30px h-lg-35px me-3" />
                            <div class="d-none d-md-flex flex-column">
                                <span class="text-white fw-bold fs-6 fs-lg-5 logo-default"
                                    style="text-shadow:2px 2px 4px rgba(0,0,0,.5);">SMK Teratai Putih Global 4</span>
                                <span class="text-white fw-semibold fs-7 logo-default"
                                    style="text-shadow:2px 2px 4px rgba(0,0,0,.5);">BKK & Tracer Study</span>
                                <span class="text-gray-800 fw-bold fs-7 logo-sticky">SMK Teratai Putih Global 4</span>
                                <span class="text-gray-700 fw-semibold fs-8 logo-sticky">BKK & Tracer Study</span>
                            </div>
                        </a>
                    </div>
                    <!--end::Logo-->

                    <!--begin::Desktop Menu-->
                    <div class="d-none d-lg-block" id="kt_header_nav_wrapper">
                        <div class="menu menu-gray-400 menu-hover-primary fw-bold fs-4 fs-md-5 order-1 mb-5 mb-md-0"
                            id="kt_landing_menu" data-kt-menu="true">

                            <div class="menu-item">
                                <a class="menu-link nav-link <?= isActive('') || isActive('beranda') ? 'active' : '' ?> py-3 px-4 px-xxl-6"
                                    href="<?= site_url('/') ?>">Beranda</a>
                            </div>

                            <!-- Dropdown Informasi -->
                            <div class="menu-item" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-start">
                                <span class="menu-link nav-link py-3 px-4 px-xxl-6">
                                    <span class="menu-title">Informasi</span>
                                    <span class="menu-arrow d-lg-none"></span>
                                </span>
                                <div class="menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-200px">
                                    <?php if ($isLoggedIn && in_array((int)$userRole, [4])): ?>
                                        <div class="menu-item px-3">
                                            <a href="<?= site_url('pelamar/tracer') ?>"
                                                class="menu-link px-3 <?= isActive('pelamar/tracer') ? 'active' : '' ?>">
                                                <span class="menu-icon"><i class="fa-solid fa-graduation-cap fs-5"></i></span>
                                                <span class="menu-title">Tracer Alumni</span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="menu-item px-3">
                                        <a href="<?= site_url('perusahaan') ?>"
                                            class="menu-link px-3 <?= isActive('perusahaan') ? 'active' : '' ?>">
                                            <span class="menu-icon"><i class="fa-solid fa-building fs-5"></i></span>
                                            <span class="menu-title">Perusahaan</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link nav-link <?= isActive('lowongan') ? 'active' : '' ?> py-3 px-4 px-xxl-6"
                                    href="<?= site_url('lowongan') ?>">Lowongan Kerja</a>
                            </div>
                        </div>
                    </div>
                    <!--end::Desktop Menu-->

                    <!--begin::Auth Area-->
                    <div class="flex-equal text-end ms-1">
                        <?php if ($isLoggedIn): ?>
                            <div class="d-inline-flex align-items-center">
                                <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
                                    data-kt-menu-trigger="click"
                                    data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <img src="<?= esc($userAvatar) ?>" alt="Avatar"
                                        style="width:45px;height:45px;object-fit:cover;border-radius:.475rem;" />
                                </div>
                                <!-- User dropdown -->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content d-flex align-items-center px-3">
                                            <div class="symbol symbol-50px me-5">
                                                <img alt="Avatar" src="<?= esc($userAvatar) ?>" style="object-fit:cover;" />
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="fw-bolder d-flex align-items-center fs-5">
                                                    <?= esc($userName) ?>
                                                </div>
                                                <span class="fw-bold text-muted fs-7"><?= esc($userEmail) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-2"></div>
                                    <div class="menu-item px-5">
                                        <a href="<?= site_url('profil') ?>" class="menu-link px-5">
                                            <span class="menu-icon"><i class="fa-solid fa-user fs-5"></i></span>
                                            <span class="menu-title">Profil Saya</span>
                                        </a>
                                    </div>
                                    <div class="separator my-2"></div>
                                    <div class="menu-item px-5">
                                        <form method="POST" action="<?= site_url('logout') ?>">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-light-danger w-100">
                                                <i class="ki-duotone ki-exit-right fs-2">
                                                    <span class="path1"></span><span class="path2"></span>
                                                </i>
                                                Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?= site_url('login') ?>" class="btn btn-success me-2">Masuk</a>
                            <a href="<?= site_url('register') ?>" class="btn btn-light">Daftar</a>
                        <?php endif; ?>
                    </div>
                    <!--end::Auth Area-->

                </div>
            </div>
        </div>
        <!--end::Sticky Header-->

        <?= $this->renderSection('hero-section') ?>

    </div>
</div>
<!--end::Header Section-->