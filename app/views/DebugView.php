<?php
// filepath: c:\xampp\htdocs\Arte_para_todos\app\views\DebugView.php

require_once __DIR__ . '/../../vendor/autoload.php'; // Asegúrate de que Twig esté instalado

class DebugView {
    public static function render($data) {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $twig = new \Twig\Environment($loader);

        echo $twig->render('debug.twig', $data);
    }
}