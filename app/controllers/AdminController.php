<?php
require_once __DIR__ . '/../../core/Twig.php';

class AdminController {
    public function loginForm() {
        $twig = Twig::getInstance();
        echo $twig->render('admin_login.twig', [
            'base_url' => BASE_URL
        ]);
    }
    public function uploadMenu() {
        // Logic to upload menu
        echo "Menu uploaded successfully.";
    }
}