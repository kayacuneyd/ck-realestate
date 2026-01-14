<?php

/**
 * Agent Module Routes
 */

namespace App\Modules\Agent\Config;

use Config\Services;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Frontend Routes
 * --------------------------------------------------------------------
 */
$routes->group('agents', ['namespace' => 'App\Modules\Agent\Controllers\Frontend'], function ($routes) {
    $routes->get('/', 'AgentController::index');
    $routes->get('(:segment)', 'AgentController::show/$1');
});

/*
 * --------------------------------------------------------------------
 * Admin Routes (protected by auth filter)
 * --------------------------------------------------------------------
 */
$routes->group('admin/agents', ['namespace' => 'App\Modules\Agent\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'AgentController::index');
    $routes->get('create', 'AgentController::create');
    $routes->post('/', 'AgentController::store');
    $routes->get('(:num)', 'AgentController::show/$1');
    $routes->get('(:num)/edit', 'AgentController::edit/$1');
    $routes->put('(:num)', 'AgentController::update/$1');
    $routes->post('(:num)', 'AgentController::update/$1');
    $routes->delete('(:num)', 'AgentController::delete/$1');
    $routes->post('(:num)/delete', 'AgentController::delete/$1');
});
