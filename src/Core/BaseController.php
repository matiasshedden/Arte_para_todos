<?php

namespace ArtePT\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController
{
    protected $twig;
    
    public function __construct()
    {
        $this->initializeTwig();
    }
    
    protected function initializeTwig()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, [
            'cache' => DEBUG ? false : __DIR__ . '/../../storage/cache',
            'debug' => DEBUG
        ]);
        
        // Add global variables
        $this->twig->addGlobal('base_url', BASE_URL);
        $this->twig->addGlobal('app_name', $_ENV['APP_NAME'] ?? 'Arte para Todos');
    }
    
    protected function render($template, $data = [])
    {
        // Add flash messages to data
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $data['flash_messages'] = [
            'success' => $_SESSION['flash_success'] ?? null,
            'error' => $_SESSION['flash_error'] ?? null,
            'info' => $_SESSION['flash_info'] ?? null
        ];
        
        // Clear flash messages
        unset($_SESSION['flash_success'], $_SESSION['flash_error'], $_SESSION['flash_info']);
        
        echo $this->twig->render($template, $data);
    }
    
    protected function redirectTo($path)
    {
        $url = BASE_URL . '/public' . $path;
        header("Location: $url");
        exit;
    }
    
    protected function flashMessage($type, $message)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION["flash_$type"] = $message;
    }
    
    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function validateCsrf($token)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    protected function generateCsrfToken()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }
}
