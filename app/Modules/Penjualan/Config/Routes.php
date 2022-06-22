<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('kasir', ['filter' => 'auth', 'namespace' => 'App\Modules\Penjualan\Controllers'], function($routes){
	$routes->get('/', 'Penjualan::index');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Penjualan\Controllers\Api'], function($routes){
    $routes->get('keranjang', 'Keranjang::index');
	$routes->get('keranjang/(:segment)', 'Keranjang::show/$1');
	$routes->post('keranjang/save', 'Keranjang::create');
	$routes->put('keranjang/update/(:segment)', 'Keranjang::update/$1');
	$routes->delete('keranjang/delete/(:segment)', 'Keranjang::delete/$1');
	$routes->delete('keranjang/reset', 'Keranjang::truncate');
});