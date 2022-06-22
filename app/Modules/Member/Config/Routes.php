<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('member', ['filter' => 'auth', 'namespace' => 'App\Modules\Member\Controllers'], function($routes){
	$routes->add('/', 'Member::index');
});


$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Member\Controllers\Api'], function($routes){
    $routes->get('member', 'Member::index');
	$routes->get('member/(:segment)', 'Member::show/$1');
	$routes->post('member/save', 'Member::create');
	$routes->put('member/update/(:segment)', 'Member::update/$1');
	$routes->delete('member/delete/(:segment)', 'Member::delete/$1');
});