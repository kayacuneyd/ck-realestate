<?php

/**
 * Message Module Routes
 */

use App\Modules\Message\Controllers\Admin\MessageController;
use App\Modules\Message\Controllers\Frontend\ContactController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Frontend routes
$routes->post('contact/send', [ContactController::class, 'send']);

// Admin routes (protected by auth filter)
$routes->group('admin/messages', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', [MessageController::class, 'index']);
    $routes->get('(:num)', [MessageController::class, 'show/$1']);
    $routes->post('(:num)/reply', [MessageController::class, 'reply/$1']);
    $routes->post('(:num)/delete', [MessageController::class, 'delete/$1']);
});
