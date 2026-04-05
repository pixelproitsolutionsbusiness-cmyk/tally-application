<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('auth', function ($routes) {
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
    $routes->post('logout', 'AuthController::logout');
});
$routes->group('example', ['filter' => 'auth'], function ($routes) {
    $routes->get('protected', 'ExampleController::protectedEndpoint');
});
$routes->group('companies', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'CompanyController::index');
    $routes->post('create', 'CompanyController::create');
    $routes->put('update/(:num)', 'CompanyController::update/$1');
    $routes->delete('delete/(:num)', 'CompanyController::delete/$1');
});
$routes->group('customers', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'CustomerController::index');
    $routes->post('create', 'CustomerController::create');
    $routes->put('update/(:num)', 'CustomerController::update/$1');
    $routes->delete('delete/(:num)', 'CustomerController::delete/$1');
});
$routes->group('products', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ProductController::index');
    $routes->post('create', 'ProductController::create');
    $routes->put('update/(:num)', 'ProductController::update/$1');
    $routes->delete('delete/(:num)', 'ProductController::delete/$1');
});
