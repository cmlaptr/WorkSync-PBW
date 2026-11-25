<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Rute Publik (Autentikasi)
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

// Rute Terproteksi (Wajib Login)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');

    // Tugas (Dapat diakses Admin & Anggota; pembatasan detail diatur di Controller)
    $routes->get('tugas', 'TugasController::index');
    $routes->get('tugas/detail/(:num)', 'TugasController::detail/$1');
    $routes->post('tugas/update-status/(:num)', 'TugasController::updateStatus/$1');

    // Khusus Admin (CRUD Master Data & Penugasan)
    $routes->group('', ['filter' => 'role:Admin'], static function ($routes) {
        // CRUD Tugas penuh
        $routes->get('tugas/create', 'TugasController::create');
        $routes->post('tugas/store', 'TugasController::store');
        $routes->get('tugas/edit/(:num)', 'TugasController::edit/$1');
        $routes->post('tugas/update/(:num)', 'TugasController::update/$1');
        $routes->post('tugas/delete/(:num)', 'TugasController::delete/$1');

        // CRUD Kategori
        $routes->get('kategori', 'KategoriController::index');
        $routes->post('kategori/store', 'KategoriController::store');
        $routes->post('kategori/update/(:num)', 'KategoriController::update/$1');
        $routes->post('kategori/delete/(:num)', 'KategoriController::delete/$1');

        // CRUD Users
        $routes->get('users', 'UserController::index');
        $routes->post('users/store', 'UserController::store');
        $routes->post('users/delete/(:num)', 'UserController::delete/$1');
    });
});
