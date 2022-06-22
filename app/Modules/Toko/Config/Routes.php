<?php

if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group('toko', ['filter' => 'auth', 'namespace' => 'App\Modules\Toko\Controllers'], function ($routes) {
	$routes->add('/', 'Toko::index');
});


$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Toko\Controllers\Api'], function ($routes) {
	$routes->get('toko', 'Toko::index');
	$routes->put('toko/update/(:segment)', 'Toko::update/$1');
});
