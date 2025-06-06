<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'User\Awal::index');
$routes->get('login', 'Login::index');
$routes->get('login/home', 'Login::home');
$routes->post('login/proses', 'Login::proses');
$routes->get('user_jk', 'User::Jenis_Bibir');
$routes->get('jenisbibir', 'Jenis_Bibir::index');

$routes->get('user/awal', 'User\Awal::index');
$routes->post('User/Awal/simpan_nama', 'User\Awal::simpan_nama');
$routes->get('user/jenis_bibir', 'User\Jenis_Bibir::index');
$routes->post('user/jenis_bibir', 'User\Jenis_Bibir::index');
$routes->post('User/Jenis_Bibir/proses_perhitungan', 'User\Jenis_Bibir::proses_perhitungan');
$routes->get('User/Jenis_Bibir/rekomendasi/(:any)', 'User\Jenis_Bibir::rekomendasi/$1');
$routes->get('User/Jenis_Bibir/rekomendasi', 'User\Jenis_Bibir::rekomendasi');
$routes->post('User/Jenis_Bibir/rekomendasi', 'User\Jenis_Bibir::rekomendasi');

$routes->get('user/rekomendasi', 'User\Rekomendasi::index');

$routes->get('User/KBSController/profile_matching', 'User\KBSController::profile_matching');
$routes->post('User/KBSController/submit_sus_feedback', 'User\KBSController::submit_sus_feedback');
$routes->post('User/KBSController/submit_csat_feedback', 'User\KBSController::submit_csat_feedback');
$routes->get('User/KBSController/product_button/(:any)/(:num)', 'User\KBSController::product_button/$1/$2');
$routes->get('User/KBSController/save_my_recommendation/(:segment)', 'User\KBSController::save_my_recommendation/$1');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // Produk
    $routes->get('produk', 'Produk::index');
    $routes->get('Produk', 'Produk::index');
    $routes->get('Produk/tambah', 'produk::tambah_data');
    $routes->post('Produk/tambah', 'produk::proses_tambah_data');
    $routes->get('Produk/hapus/(:num)', 'produk::hapusdata/$1');
    $routes->get('Produk/editdata/(:num)', 'produk::editdata/$1');
    $routes->post('Produk/proses_editdata/(:num)', 'produk::proses_editdata/$1');
    $routes->get('Produk/tambah_data', 'Produk::tambah_data');
    $routes->post('Produk/proses_tambah_data_v1', 'Produk::proses_tambah_data_v1');
    $routes->post('Produk/proses_tambah_data', 'Produk::proses_tambah_data');
    $routes->get('Produk/hapusdata/(:num)', 'produk::hapusdata/$1');

    // Jenis Lipstik
    $routes->get('Jenis_lipstik', 'Jenis_lipstik::index');
    $routes->get('jenis_lipstik', 'Jenis_lipstik::index');
    $routes->get('Jenis_lipstik/tambah', 'Jenis_lipstik::tambah_dataJL');
    $routes->post('Jenis_lipstik/tambah', 'Jenis_lipstik::proses_tambah_data');
    $routes->get('Jenis_lipstik/hapus/(:num)', 'Jenis_lipstik::hapusdata/$1');
    $routes->get('Jenis_lipstik/editdata/(:num)', 'Jenis_lipstik::editdata/$1');
    $routes->post('Jenis_lipstik/proses_editdata/(:num)', 'Jenis_lipstik::proses_editdata/$1');
    $routes->get('Jenis_lipstik/tambah_dataJL', 'Jenis_lipstik::tambah_dataJL');
    $routes->post('Jenis_lipstik/proses_edit_data/(:num)', 'Jenis_lipstik::proses_edit_data/$1');
    $routes->post('Jenis_lipstik/proses_tambah_data', 'Jenis_lipstik::proses_tambah_data');
    $routes->get('Jenis_lipstik/hapusdata/(:num)', 'Jenis_lipstik::hapusdata/$1');

    // Jenis Bibir
    $routes->get('Jenis_bibir', 'Jenis_bibir::index');
    $routes->get('jenis_bibir', 'jenis_bibir::index');
    $routes->get('Jenis_Bibir/tambah', 'Jenis_bibir::tambah_data');
    $routes->post('Jenis_Bibir/proses_tambah_data', 'Jenis_bibir::proses_tambah_data');
    $routes->get('Jenis_Bibir/hapus/(:num)', 'Jenis_bibir::hapusdata/$1');
    $routes->get('Jenis_Bibir/editdata/(:num)', 'Jenis_bibir::editdata/$1');
    $routes->post('Jenis_Bibir/proses_editdata/(:num)', 'Jenis_bibir::proses_editdata/$1');
    $routes->get('Jenis_Bibir/tambah_data', 'Jenis_bibir::tambah_data');
    $routes->get('Jenis_Bibir/hapusdata/(:num)', 'Jenis_bibir::hapusdata/$1');

    //Tone Kulit
    $routes->get('Tone_Kulit', 'Tone_Kulit::index');
    $routes->get('tone_kulit', 'tone_kulit::index');
    $routes->get('Tone_Kulit/tambah', 'Tone_Kulit::tambah_data');
    $routes->post('Tone_Kulit/proses_tambah_data', 'Tone_Kulit::proses_tambah_data');
    $routes->get('Tone_Kulit/hapus/(:num)', 'Tone_Kulit::hapusdata/$1');
    $routes->get('Tone_Kulit/editdata/(:num)', 'Tone_Kulit::editdata/$1');
    $routes->post('Tone_Kulit/proses_editdata/(:num)', 'Tone_Kulit::proses_editdata/$1');
    $routes->get('Tone_Kulit/tambah_data', 'Tone_Kulit::tambah_data');
    $routes->get('Tone_Kulit/hapusdata/(:num)', 'Tone_Kulit::hapusdata/$1');

    // Kriteria
    $routes->get('Kriteria', 'Kriteria::index');
    $routes->get('kriteria', 'Kriteria::index');
    $routes->get('Kriteria/tambah', 'Kriteria::tambah_data');
    $routes->post('Kriteria/tambah', 'Kriteria::proses_tambah_data');
    $routes->get('Kriteria/hapus/(:num)', 'Kriteria::hapusdata/$1');
    $routes->get('Kriteria/editdata/(:num)', 'Kriteria::editdata/$1');
    $routes->post('Kriteria/proses_editdata/(:num)', 'Kriteria::proses_editdata/$1');
    $routes->post('Kriteria/proses_edit_data/(:num)', 'Kriteria::proses_edit_data/$1');
    $routes->get('Kriteria/tambah_data', 'Kriteria::tambah_data');
    $routes->post('Kriteria/proses_tambah_data', 'Kriteria::proses_tambah_data');
    $routes->get('Kriteria/hapusdata/(:num)', 'Kriteria::hapusdata/$1');

    // SUS
    $routes->get('SUS', 'SUS::index');
    $routes->post('reset-sus', 'SUS::reset');
    $routes->get('CSAT', 'CSAT::index');
    $routes->post('reset-csat', 'CSAT::reset');
});





