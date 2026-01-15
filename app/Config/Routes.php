<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;
use Config\Services;

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 *
 * This file defines the routes for the application. It sets
 * defaults and maps URIs to controllers and methods.
 */

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

$routes->setDefaultNamespace('App\\Controllers');
$routes->setDefaultController('Frontend\\HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// You can enable Auto Routing (Improved) if you wish to avoid defining
// all routes by hand. The route definitions here make it explicit which
// routes are available.
// $routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Home page
$routes->get('/', 'Frontend\\HomeController::index');

// Authentication
$routes->get('login', 'Auth\\LoginController::index');
$routes->post('login', 'Auth\\LoginController::attempt');
$routes->get('logout', 'Auth\\LoginController::logout');

// Admin routes group with auth filter
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // When visiting /admin or /admin/dashboard, show the dashboard
    $routes->get('/', 'Admin\\DashboardController::index');
    $routes->get('dashboard', 'Admin\\DashboardController::index');

    // Settings
    $routes->get('settings', 'Admin\\SettingsController::index');
    $routes->post('settings', 'Admin\\SettingsController::save');

    // Content Management
    $routes->get('content', 'Admin\\ContentController::index');
    $routes->get('content/(:segment)', 'Admin\\ContentController::edit/$1');
    $routes->post('content/(:segment)', 'Admin\\ContentController::save/$1');

    // Sponsor Management
    $routes->group('sponsors', function ($routes) {
        $routes->get('/', 'Admin\\SponsorController::index');
        $routes->get('create', 'Admin\\SponsorController::create');
        $routes->post('store', 'Admin\\SponsorController::store');
        $routes->get('edit/(:num)', 'Admin\\SponsorController::edit/$1');
        $routes->post('update/(:num)', 'Admin\\SponsorController::update/$1');
        $routes->get('delete/(:num)', 'Admin\\SponsorController::delete/$1');
    });
});

/*
 * --------------------------------------------------------------------
 * Module Routes
 * --------------------------------------------------------------------
 */

// Load Property Module routes
require_once APPPATH . 'Modules/Property/Config/Routes.php';

// Load Agent Module routes
require_once APPPATH . 'Modules/Agent/Config/Routes.php';

// Load Page Module routes
require_once APPPATH . 'Modules/Page/Config/Routes.php';

// Load Message Module routes
require_once APPPATH . 'Modules/Message/Config/Routes.php';

// Load OpenImmo Module routes
require_once APPPATH . 'Modules/OpenImmo/Config/Routes.php';


