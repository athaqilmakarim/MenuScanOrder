<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'MenuController::index');
$routes->get('/menu_page/(:num)', 'MenuController::menu_page/$1', ['filter' => 'login']);
$routes->get('/create_category/(:num)', 'MenuController::create_category/$1', ['filter' => 'login']);
$routes->get('/restaurant_page/(:num)', 'MenuController::restaurant_page/$1', ['filter' => 'login']);
$routes->get('/admin_page', 'MenuController::admin_page');
$routes->get('/create_table/(:num)', 'MenuController::create_table/$1', ['filter' => 'login']);
$routes->get('/login', 'Auth::google_login');  // Route to initiate Google login
$routes->get('/login/callback', 'Auth::google_callback');  // Callback route after Google auth
$routes->get('/logout', 'Auth::logout');
$routes->get('/login_page', 'MenuController::login_page');
$routes->get('/order_management/(:num)', 'MenuController::order_management/$1', ['filter' => 'login']);
$routes->get('/user_menu/(:num)', 'MenuController::user_menu/$1');

$routes->get('/resume/(:num)', 'MenuController::resume/$1', ['filter' => 'login']); 

$routes->resource('restaurant');
$routes->resource('category');
$routes->resource('items');
$routes->resource('table');
$routes->resource('orders');
$routes->resource('orderdetails');

$routes->post('users/update/(:num)', 'MenuController::updateUser/$1');
$routes->post('/table/create', 'Table::create');
$routes->post('/orders/create', 'Orders::create');