<?php

/**
 * Page Module Routes
 */

namespace App\Modules\Page\Config;

use Config\Services;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Frontend Routes
 * --------------------------------------------------------------------
 */
$routes->group('/', ['namespace' => 'App\Modules\Page\Controllers\Frontend'], function ($routes) {
    $routes->get('about', 'PageController::about');
    $routes->get('contact', 'PageController::contact');
    // Generic page route - can be enabled if needed
    // $routes->get('p/(:segment)', 'PageController::show/$1');
});

/*
 * --------------------------------------------------------------------
 * Admin Routes (protected by auth filter)
 * --------------------------------------------------------------------
 */
$routes->group('admin/pages', ['namespace' => 'App\Modules\Page\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PageController::index');
    $routes->get('create', 'PageController::create');
    $routes->post('/', 'PageController::store');
    $routes->post('upload', 'PageController::upload');
    $routes->get('(:num)', 'PageController::show/$1');
    $routes->get('(:num)/edit', 'PageController::edit/$1');
    $routes->put('(:num)', 'PageController::update/$1');
    $routes->post('(:num)', 'PageController::update/$1');
    $routes->delete('(:num)', 'PageController::delete/$1');
    $routes->post('(:num)/delete', 'PageController::delete/$1');
});
