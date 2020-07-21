<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('login', 'Pengguna::login');
$routes->post('login', 'Pengguna::cobaLogin');
$routes->get('logout', 'Pengguna::logout');

// pengguna
$routes->group('pengguna', function ($routes) {
	$routes->get('/', 'Pengguna::index', ['filter' => 'role:staff_tu']);
	$routes->post('json', 'Pengguna::json', ['filter' => 'role:staff_tu']);

	$routes->get('tambah', 'Pengguna::tambah', ['filter' => 'role:staff_tu']);
	$routes->post('tambah', 'Pengguna::simpan', ['filter' => 'role:staff_tu']);

	$routes->get('(:num)/edit', 'Pengguna::edit/$1', ['filter' => 'role:staff_tu']);
	$routes->post('(:num)/edit', 'Pengguna::perbarui/$1', ['filter' => 'role:staff_tu']);

	$routes->delete('(:num)/hapus', 'Pengguna::hapus/$1', ['filter' => 'role:staff_tu']);
});

// pengajuan
$routes->group('pengajuan', function ($routes) {
	$routes->get('/', 'Pengajuan::index', ['filter' => 'role:siswa']);
	$routes->post('json', 'Pengajuan::json', ['filter' => 'role:siswa,kajur']);

	$routes->get('tambah', 'Pengajuan::tambah', ['filter' => 'role:siswa']);
	$routes->post('tambah', 'Pengajuan::simpan', ['filter' => 'role:siswa']);
});

// persetujuan
$routes->group('persetujuan', function ($routes) {
	$routes->get('/', 'Persetujuan::index', ['filter' => 'role:kajur']);
	$routes->post('json', 'Persetujuan::json', ['filter' => 'role:kajur']);

	$routes->get('(:num)/tambah', 'Persetujuan::tambah/$1', ['filter' => 'role:kajur']);
	$routes->post('(:num)/tambah', 'Persetujuan::simpan/$1', ['filter' => 'role:kajur']);
});

// lokasi
$routes->group('lokasi', function ($routes) {
	$routes->get('/', 'Lokasi::index', ['filter' => 'role:staff_tu']);
	$routes->post('json', 'Lokasi::json', ['filter' => 'role:staff_tu']);

	$routes->get('tambah', 'Lokasi::tambah', ['filter' => 'role:staff_tu']);
	$routes->post('tambah', 'Lokasi::simpan', ['filter' => 'role:staff_tu']);

	$routes->get('(:num)/edit', 'Lokasi::edit/$1', ['filter' => 'role:staff_tu']);
	$routes->post('(:num)/edit', 'Lokasi::perbarui/$1', ['filter' => 'role:staff_tu']);

	$routes->delete('(:num)/hapus', 'Lokasi::hapus/$1', ['filter' => 'role:staff_tu']);
});
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
