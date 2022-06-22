<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('user', ['filter' => 'auth', 'namespace' => 'App\Modules\User\Controllers'], function($routes){
	$routes->add('/', 'User::index');
});


$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\User\Controllers\Api'], function($routes){
	$routes->get('user', 'User::index');
	$routes->post('user/save', 'User::create');
	$routes->put('user/update/(:segment)', 'User::update/$1');
	$routes->delete('user/delete/(:segment)', 'User::delete/$1');
	$routes->put('user/setactive/(:segment)', 'User::setActive/$1');
	$routes->put('user/setrole/(:segment)', 'User::setRole/$1');
	$routes->post('user/changepassword', 'User::changePassword');
});