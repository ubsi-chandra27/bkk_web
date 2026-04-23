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
$routes->get('tracer-alumni', 'HomeController::tracerAlumni');

// ===== AUTH =====
$routes->post('login', 'AuthController::login');
$routes->post('register', 'AuthController::register');
$routes->post('logout', 'AuthController::logout', ['filter' => 'auth']);
$routes->get('logout', 'AuthController::logout', ['filter' => 'auth']);

// Guest only
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'AuthController::loginForm');
    $routes->get('register', 'AuthController::registerForm');
});

// ===== PROFIL PELAMAR (role 4, 5) =====
$routes->get('profil', 'ProfilController::index', ['filter' => 'auth:4,5']);
$routes->get('profil/edit', 'ProfilController::edit', ['filter' => 'auth:4,5']);
$routes->post('profil/update', 'ProfilController::update', ['filter' => 'auth:4,5']);
$routes->post('profil/update-tracer', 'ProfilController::saveTracer', ['filter' => 'auth:4,5']);
$routes->post('profil/upload-berkas', 'ProfilController::uploadBerkas', ['filter' => 'auth:4,5']);

// ===== ADMIN (role 1, 2) =====
$routes->group('', ['filter' => 'auth:1,2'], function ($routes) {

    $routes->get('dashboard', 'admin\DashboardController::index');

    // Data Admin
    $routes->get('admin/data-admin', 'admin\DataAdminController::index');
    $routes->post('admin/data-admin', 'admin\DataAdminController::store');
    $routes->post('admin/data-admin/update/(:num)', 'admin\DataAdminController::update/$1');
    $routes->get('admin/data-admin/delete/(:num)', 'admin\DataAdminController::delete/$1');

    // Data Pelamar
    $routes->get('admin/data-pelamar', 'admin\DataPelamarController::index');
    $routes->post('admin/data-pelamar', 'admin\DataPelamarController::store');
    $routes->post('admin/data-pelamar/update/(:num)', 'admin\DataPelamarController::update/$1');
    $routes->post('admin/data-pelamar/update-status/(:num)', 'admin\DataPelamarController::updateStatusPendaftaran/$1');
    $routes->get('admin/data-pelamar/delete/(:num)', 'admin\DataPelamarController::delete/$1');
    $routes->get('admin/data-pelamar/profil/(:num)', 'Admin\ProfilPelamarController::show/$1');
    $routes->get('admin/data-pelamar/profil/(:num)/edit', 'Admin\ProfilPelamarController::edit/$1');
    $routes->post('admin/data-pelamar/profil/(:num)/update', 'Admin\ProfilPelamarController::update/$1');
    $routes->post('admin/data-pelamar/profil/(:num)/update-tracer', 'Admin\ProfilPelamarController::updateTracer/$1');
    $routes->post('admin/data-pelamar/profil/(:num)/upload-berkas', 'Admin\ProfilPelamarController::uploadBerkas/$1');

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
    $routes->get('admin/data-lowongan', 'Admin\DataLowonganController::index');
    $routes->post('admin/data-lowongan/store', 'Admin\DataLowonganController::store');
    $routes->post('admin/data-lowongan/update/(:num)', 'Admin\DataLowonganController::update/$1');
    $routes->get('admin/data-lowongan/delete/(:num)', 'Admin\DataLowonganController::delete/$1');
    $routes->get('admin/data-lowongan/show/(:num)', 'Admin\DataLowonganController::show/$1');

    // Data Lamaran
    $routes->get('admin/data-lamaran', 'admin\DataLamaranController::index');
    $routes->post('admin/data-lamaran/update/(:num)', 'admin\DataLamaranController::update/$1');
    $routes->get('admin/data-lamaran/delete/(:num)', 'admin\DataLamaranController::delete/$1');

    // Data Tracer Alumni
    $routes->get('admin/data-tracer', 'admin\DataTracerController::index');
    $routes->post('admin/data-tracer/update/(:num)', 'admin\DataTracerController::update/$1');
    $routes->get('admin/data-tracer/delete/(:num)', 'admin\DataTracerController::delete/$1');
});
