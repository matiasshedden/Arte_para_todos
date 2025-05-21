<?php

namespace App\Controllers;

// It's important to adjust the relative paths based on the location of AdminController.php
require_once __DIR__ . '/../../config/config.php'; // Adjust path to config.php
require_once __DIR__ . '/../../core/Twig.php';     // Adjust path to core/Twig.php

use Twig; // Alias the global Twig class to the current namespace

class AdminController {
    public function showLoginForm() {
        // Get Twig instance from the core Twig service
        $twig = \Twig::getInstance(); // Use the global Twig class

        // Render the admin login template
        // The 'base_url' is passed so that template paths for CSS/JS/images work correctly.
        // The {{ base_url }} in Twig templates seems to be just a placeholder for this value.
        echo $twig->render('admin.twig', [
            'title' => 'Admin Login',
            'base_url' => BASE_URL 
        ]);
    }
}
?>
