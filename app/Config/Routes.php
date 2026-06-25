<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ===== LANDING (public) =====
$routes->get('/', 'HomeController::index');
$routes->get('lowongan', 'HomeController::lowongan');
$routes->get('lowongan/(:num)', 'HomeController::lowonganDetail/$1');
$routes->get('lowongan/apply/(:num)', 'HomeController::apply/$1', ['filter' => 'auth']);
$routes->post('lowongan/apply/(:num)', 'HomeController::apply/$1', ['filter' => 'auth']);
$routes->get('perusahaan', 'HomeController::perusahaan');
$routes->get('tracer-alumni', 'TracerAlumni::index');
$routes->get('tracer-study', 'TracerStudy::index', ['filter' => 'auth:4']);
$routes->post('tracer-study/save', 'TracerStudy::save', ['filter' => 'auth:4']);

// ===== AUTH =====
$routes->post('login', 'AuthController::login');
$routes->post('register', 'AuthController::register');
$routes->post('logout', 'AuthController::logout', ['filter' => 'auth']);
$routes->get('logout', 'AuthController::logout', ['filter' => 'auth']);
$routes->get('verify-email/(:segment)', 'AuthController::verifyEmail/$1');
$routes->get('forgot-password', 'AuthController::forgotPassword');
$routes->post('forgot-password', 'AuthController::processForgotPassword');
$routes->get('reset-password/(:segment)', 'AuthController::resetPassword/$1');
$routes->post('reset-password/(:segment)', 'AuthController::processResetPassword/$1');

// Guest only
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'AuthController::loginForm');
    $routes->get('register', 'AuthController::registerForm');
    $routes->get('auth/google', 'AuthController::redirectToGoogle');
    $routes->get('auth/google/callback', 'AuthController::handleGoogleCallback');
});

// ===== PROFIL PELAMAR (role 4, 5) =====
$routes->get('profil', 'ProfilController::index', ['filter' => 'auth:4,5']);
$routes->get('profil/edit', 'ProfilController::edit', ['filter' => 'auth:4,5']);
$routes->post('profil/update', 'ProfilController::update', ['filter' => 'auth:4,5']);
$routes->post('profil/update-tracer', 'ProfilController::saveTracer', ['filter' => 'auth:4,5']);
$routes->post('profil/upload-berkas', 'ProfilController::uploadBerkas', ['filter' => 'auth:4,5']);
$routes->get('profil/riwayat-kerja', 'ProfilController::riwayatKerja', ['filter' => 'auth:4,5']);
$routes->post('profil/riwayat-kerja', 'ProfilController::storeRiwayatKerja', ['filter' => 'auth:4,5']);
$routes->put('profil/riwayat-kerja/(:num)', 'ProfilController::updateRiwayatKerja/$1', ['filter' => 'auth:4,5']);
$routes->delete('profil/riwayat-kerja/(:num)', 'ProfilController::destroyRiwayatKerja/$1', ['filter' => 'auth:4,5']);

// ===== ADMIN DUDI (role 3) =====
$routes->group('admindudi', ['filter' => 'auth:3'], function ($routes) {
    $routes->get('profil-perusahaan', 'admin\ProfilPerusahaanController::index');
    $routes->post('profil-perusahaan/update', 'admin\ProfilPerusahaanController::update');
});

// ===== ADMIN (role 1, 2, 3) =====
$routes->group('', ['filter' => 'auth:1,2,3'], function ($routes) {

    $routes->get('dashboard', 'admin\DashboardController::index');
    $routes->get('admin/profil-saya', 'admin\ProfilSayaController::index');
    $routes->get('admin/profil-saya/edit', 'admin\ProfilSayaController::edit');
    $routes->post('admin/profil-saya/update', 'admin\ProfilSayaController::update');

    // Data Admin
    $routes->get('admin/data-admin', 'admin\DataAdminController::index');
    $routes->post('admin/data-admin', 'admin\DataAdminController::store');
    $routes->get('admin/data-admin/(:num)/profil', 'admin\DataAdminController::profil/$1');
    $routes->get('admin/data-admin/(:num)/edit-profil', 'admin\DataAdminController::editProfil/$1');
    $routes->post('admin/data-admin/(:num)/update-profil', 'admin\DataAdminController::updateProfil/$1');
    $routes->post('admin/data-admin/update/(:num)', 'admin\DataAdminController::update/$1');
    $routes->get('admin/data-admin/delete/(:num)', 'admin\DataAdminController::delete/$1');

    // Data Pelamar
    $routes->get('admin/data-pelamar', 'admin\DataPelamarController::index');
    $routes->post('admin/data-pelamar', 'admin\DataPelamarController::store');
    $routes->post('admin/data-pelamar/update/(:num)', 'admin\DataPelamarController::update/$1');
    $routes->post('admin/data-pelamar/update-status/(:num)', 'admin\DataPelamarController::updateStatusPendaftaran/$1');
    $routes->get('admin/data-pelamar/delete/(:num)', 'admin\DataPelamarController::delete/$1');
    $routes->get('admin/data-pelamar/profil/(:num)', 'admin\ProfilPelamarController::show/$1');
    $routes->get('admin/data-pelamar/profil/(:num)/edit', 'admin\ProfilPelamarController::edit/$1');
    $routes->post('admin/data-pelamar/profil/(:num)/update', 'admin\ProfilPelamarController::update/$1');
    $routes->post('admin/data-pelamar/profil/(:num)/update-tracer', 'admin\ProfilPelamarController::updateTracer/$1');
    $routes->post('admin/data-pelamar/profil/(:num)/upload-berkas', 'admin\ProfilPelamarController::uploadBerkas/$1');
    $routes->get('admin/data-pelamar/profil/(:num)/riwayat-kerja', 'admin\ProfilPelamarController::riwayatKerja/$1');
    $routes->post('admin/data-pelamar/profil/(:num)/riwayat-kerja', 'admin\ProfilPelamarController::storeRiwayatKerja/$1');
    $routes->put('admin/data-pelamar/profil/(:num)/riwayat-kerja/(:num)', 'admin\ProfilPelamarController::updateRiwayatKerja/$1/$2');
    $routes->delete('admin/data-pelamar/profil/(:num)/riwayat-kerja/(:num)', 'admin\ProfilPelamarController::destroyRiwayatKerja/$1/$2');

    // Data Angkatan
    $routes->get('admin/data-angkatan', 'admin\DataAngkatanController::index');
    $routes->post('admin/data-angkatan', 'admin\DataAngkatanController::store');
    $routes->post('admin/data-angkatan/update/(:num)', 'admin\DataAngkatanController::update/$1');
    $routes->get('admin/data-angkatan/delete/(:num)', 'admin\DataAngkatanController::delete/$1');

    // Data Jurusan
    $routes->get('admin/data-jurusan', 'admin\DataJurusanController::index');
    $routes->post('admin/data-jurusan', 'admin\DataJurusanController::store');
    $routes->post('admin/data-jurusan/update/(:num)', 'admin\DataJurusanController::update/$1');
    $routes->get('admin/data-jurusan/delete/(:num)', 'admin\DataJurusanController::delete/$1');

    // Data Jenis Berkas
    $routes->get('admin/data-jenis-berkas', 'admin\DataJenisBerkasController::index');
    $routes->post('admin/data-jenis-berkas', 'admin\DataJenisBerkasController::store');
    $routes->post('admin/data-jenis-berkas/update/(:num)', 'admin\DataJenisBerkasController::update/$1');
    $routes->get('admin/data-jenis-berkas/delete/(:num)', 'admin\DataJenisBerkasController::delete/$1');

    // Data Aktivitas
    $routes->get('admin/data-aktivitas', 'admin\DataAktivitasController::index');
    $routes->post('admin/data-aktivitas', 'admin\DataAktivitasController::store');
    $routes->post('admin/data-aktivitas/update/(:num)', 'admin\DataAktivitasController::update/$1');
    $routes->get('admin/data-aktivitas/delete/(:num)', 'admin\DataAktivitasController::delete/$1');

    // Data Perusahaan
    $routes->get('admin/data-perusahaan', 'admin\DataPerusahaanController::index');
    $routes->post('admin/data-perusahaan/store', 'admin\DataPerusahaanController::store');
    $routes->post('admin/data-perusahaan/update/(:num)', 'admin\DataPerusahaanController::update/$1');
    $routes->post('admin/data-perusahaan/delete/(:num)', 'admin\DataPerusahaanController::delete/$1');

    // Data Kerjasama
    $routes->get('admin/data-kerjasama', 'admin\DataKerjasamaController::index');
    $routes->post('admin/data-kerjasama/store', 'admin\DataKerjasamaController::store');
    $routes->post('admin/data-kerjasama/update/(:num)', 'admin\DataKerjasamaController::update/$1');
    $routes->post('admin/data-kerjasama/delete/(:num)', 'admin\DataKerjasamaController::delete/$1');

    // Data Lowongan
    $routes->get('admin/data-lowongan', 'admin\DataLowonganController::index');
    $routes->post('admin/data-lowongan/store', 'admin\DataLowonganController::store');
    $routes->post('admin/data-lowongan/update/(:num)', 'admin\DataLowonganController::update/$1');
    $routes->get('admin/data-lowongan/delete/(:num)', 'admin\DataLowonganController::delete/$1');
    $routes->get('admin/data-lowongan/show/(:num)', 'admin\DataLowonganController::show/$1');

    // Data Lamaran
    $routes->get('admin/data-lamaran', 'admin\DataLamaranController::index');
    $routes->post('admin/data-lamaran/update/(:num)', 'admin\DataLamaranController::update/$1');
    $routes->get('admin/data-lamaran/delete/(:num)', 'admin\DataLamaranController::delete/$1');
    $routes->get('admin/riwayat-lamaran', 'admin\DataLamaranController::riwayat');

    // Data Tracer Alumni
    $routes->get('admin/data-tracer', 'admin\DataTracerController::index');
    $routes->get('admin/data-tracer/export-excel', 'admin\DataTracerController::exportExcel');
    $routes->post('admin/data-tracer/update/(:num)', 'admin\DataTracerController::update/$1');
    $routes->get('admin/data-tracer/delete/(:num)', 'admin\DataTracerController::delete/$1');
});

// API Notifications untuk semua user yang sudah login (admin, pelamar, alumni)
$routes->group('api', ['filter' => 'auth'], function ($routes) {
    $routes->get('notifications', 'Api\NotificationController::index');
    $routes->post('notifications/read', 'Api\NotificationController::markRead');
    $routes->post('notifications/read-one', 'Api\NotificationController::markOne');
});
