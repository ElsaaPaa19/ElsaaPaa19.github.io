<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('produk', ['filter' => 'auth', 'namespace' => 'App\Modules\Produk\Controllers'], function($routes){
	$routes->get('/', 'Produk::index');
	$routes->get('baru', 'Produk::produkBaru');
	$routes->get('(:segment)/edit', 'Produk::produkEdit/$1');
});

//Routes untuk Halaman Open Api Home
$routes->group('api', ['namespace' => 'App\Modules\Produk\Controllers\Api'], function ($routes) {
	$routes->get('cari_produk', 'Produk::cariProduk');
	$routes->get('produk/terbaru', 'Produk::getProdukTerbaru');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Produk\Controllers\Api'], function($routes){
    $routes->get('produk', 'Produk::index');
	$routes->get('produk/kasir', 'Produk::getProdukKasir');
	$routes->get('produk/terbaru', 'Produk::getProdukTerbaru');
	$routes->get('produk/(:segment)', 'Produk::show/$1');
	$routes->post('produk/save', 'Produk::create');
	$routes->put('produk/update/(:segment)', 'Produk::update/$1');
	$routes->delete('produk/delete/(:segment)', 'Produk::delete/$1');
	$routes->put('produk/setaktif/(:segment)', 'Produk::setAktif/$1');
	$routes->put('produk/setstok/(:segment)', 'Produk::setStok/$1');
	$routes->put('produk/setharga/(:segment)', 'Produk::setHarga/$1');
	$routes->get('cari_produk', 'Produk::cariProduk');
	$routes->get('media/(:segment)', 'Produk::getMedia/$1');
	$routes->post('produk/exporttoexcel', 'Produk::excelExport');
	$routes->post('produk/delete/multiple', 'Produk::deleteMultiple');
});