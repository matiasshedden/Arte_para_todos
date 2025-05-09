<?php
// Load the necessary components
require_once '../core/Router.php';
require_once '../config/config.php';
require_once '../app/controllers/HomeController.php';

// Initialize the router
$router = new Router();

// Define routes
$router->add('/', [new HomeController(), 'index']);

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI']);
?>