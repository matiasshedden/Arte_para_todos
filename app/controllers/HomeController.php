<?php
require_once '../core/Twig.php';

class HomeController {
    public function index() {
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        echo $twig->render('home.twig', ['title' => 'Welcome to Arte para Todos']);
    }
}
?>