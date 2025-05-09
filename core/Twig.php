<?php
// filepath: c:\xampp\htdocs\Arte_para_todos\core\Twig.php

require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    private static $twig;

    public static function getInstance()
    {
        if (!self::$twig) {
            $loader = new FilesystemLoader(['../app/views', '../templates']); // Add templates directory
            self::$twig = new Environment($loader, [
                'cache' => '../cache', // Carpeta para la caché
                'debug' => true,       // Cambiar a false en producción
            ]);
        }

        return self::$twig;
    }
}