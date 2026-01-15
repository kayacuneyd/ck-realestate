<?php

/**
 * OpenImmo Module Routes
 */

use CodeIgniter\Router\RouteCollection;
use Config\Services;

/** @var RouteCollection $routes */
$routes = Services::routes();

// Public CRON endpoint (no auth required, should be IP-restricted or token-protected in production)
$routes->get('openimmo/process', '\App\Modules\OpenImmo\Controllers\ImportController::process');
$routes->get('openimmo/status', '\App\Modules\OpenImmo\Controllers\ImportController::status');

// Admin routes (with auth)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('import-logs', '\App\Modules\OpenImmo\Controllers\Admin\ImportLogController::index');
    $routes->post('import/trigger', '\App\Modules\OpenImmo\Controllers\ImportController::trigger');
});
