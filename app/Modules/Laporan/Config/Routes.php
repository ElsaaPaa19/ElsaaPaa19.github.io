<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('laporan', ['filter' => 'auth', 'namespace' => 'App\Modules\Laporan\Controllers'], function($routes){
	$routes->get('/', 'Laporan::index');
	$routes->get('barang-pdf', 'Laporan::barangPdf');
	$routes->get('penjualan-pdf', 'Laporan::penjualanPdf');
	$routes->get('kategori-pdf', 'Laporan::kategoriPdf');
});


$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Laporan\Controllers\Api'], function($routes){
	$routes->get('laporanproduk', 'Laporan::produk');
	$routes->get('laporanpenjualan', 'Laporan::penjualan');
	$routes->get('laporankategori', 'Laporan::kategori');
	$routes->get('laporandetailkategori', 'Laporan::detailKategori');
	$routes->get('laporanlabarugi', 'Laporan::LabaRugi');
});