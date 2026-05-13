<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth', 'Auth::auth');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');

// User Acounts routes
$routes->get('/users', 'Users::index');
$routes->post('users/save', 'Users::save');
$routes->get('users/edit/(:segment)', 'Users::edit/$1');
$routes->post('users/update', 'Users::update');
$routes->delete('users/delete/(:num)', 'Users::delete/$1');
$routes->post('users/fetchRecords', 'Users::fetchRecords');

// Dashboard Routes
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('dashboard/getStats', 'Dashboard::getStats');
$routes->get('dashboard/getRecentProducts', 'Dashboard::getRecentProducts');


// Products Routes
$routes->get('/products', 'Products::index');
$routes->post('products/save', 'Products::save');
$routes->get('products/edit/(:segment)', 'Products::edit/$1');
$routes->post('products/update', 'Products::update');
$routes->delete('products/delete/(:num)', 'Products::delete/$1');
$routes->post('products/fetchRecords', 'Products::fetchRecords');

// Logs routes for admin
$routes->get('/log', 'Logs::log');

$routes->post('sales/checkout', 'Products::checkout');
$routes->get('products/getProducts', 'Products::getProducts');
$routes->get('pos', 'Products::pos');