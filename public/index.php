<?php
/**
 * Arte para Todos - Restaurant Management System
 * Entry point for the application
 */

// Error reporting for development
if (file_exists('../.env')) {
    // Load environment variables
    $envFile = file_get_contents('../.env');
    $lines = explode("\n", $envFile);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos(trim($line), '#') !== 0) {
            putenv(trim($line));
        }
    }
}

// Load configuration
require_once '../config/config.php';

// Error reporting based on environment
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Load Composer autoloader
require_once '../vendor/autoload.php';

// Start session
session_start();

// Initialize the router
use ArtePT\Core\Router;
use ArtePT\Controllers\HomeController;
use ArtePT\Controllers\AdminController;

$router = new Router();

// Define routes with lazy loading
$router->get('/', function() {
    $controller = new HomeController();
    return $controller->index();
});

$router->post('/reservation', function() {
    $controller = new HomeController();
    return $controller->processReservation();
});

// Admin routes
$router->get('/admin', function() {
    $controller = new AdminController();
    return $controller->loginForm();
});

$router->post('/admin/login', function() {
    $controller = new AdminController();
    return $controller->login();
});

$router->get('/admin/dashboard', function() {
    $controller = new AdminController();
    return $controller->dashboard();
});

$router->post('/admin/menu/upload', function() {
    $controller = new AdminController();
    return $controller->uploadMenu();
});

$router->get('/admin/logout', function() {
    $controller = new AdminController();
    return $controller->logout();
});

// Get request method
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $requestMethod);
