<?php

if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group('nota', ['filter' => 'auth', 'namespace' => 'App\Modules\Nota\Controllers'], function ($routes) {
	$routes->get('/', 'Nota::index');
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Nota\Controllers\Api'], function ($routes) {
	$routes->get('nota', 'Nota::index');
	$routes->post('nota/save', 'Nota::create');
	$routes->get('nota/(:segment)', 'Nota::show/$1');
	$routes->put('nota/update/(:segment)', 'Nota::update/$1');
	$routes->delete('nota/delete/(:segment)', 'Nota::delete/$1');
	$routes->get('cetaknota/(:segment)', 'Nota::cetakNota/$1');
});
