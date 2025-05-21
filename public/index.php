<?php
// Load the necessary components
require_once '../core/Router.php';
require_once '../config/config.php';
require_once '../app/controllers/HomeController.php';
require_once '../app/controllers/DebugController.php'; // Corregido

// Initialize the router
$router = new Router();

// Define routes
$router->add('/', [new HomeController(), 'index']);
$router->add('/debug', [new DebugController(), 'index']);
$router->add('/admin', ['App\\Controllers\\AdminController', 'showLoginForm']); // New route for admin login

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI']);
?>