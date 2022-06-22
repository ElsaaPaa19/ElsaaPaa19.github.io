<?php

if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group('kas', ['filter' => 'auth', 'namespace' => 'App\Modules\Kas\Controllers'], function ($routes) {
	$routes->add('/', 'Kas::index');
});


$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Kas\Controllers\Api'], function ($routes) {
	$routes->get('kas', 'Kas::index');
	$routes->get('kas/saldo', 'Kas::saldo');
	$routes->get('kas/(:segment)', 'Kas::show/$1');
	$routes->post('kas/save', 'Kas::create');
	$routes->put('kas/update/(:segment)', 'Kas::update/$1');
	$routes->delete('kas/delete/(:segment)', 'Kas::delete/$1');
});
