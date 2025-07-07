<?php

namespace ArtePT\Core;

class Router
{
    private $routes = [];
    private $middlewares = [];
    
    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
    }
    
    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
    }
    
    public function put($path, $callback)
    {
        $this->addRoute('PUT', $path, $callback);
    }
    
    public function delete($path, $callback)
    {
        $this->addRoute('DELETE', $path, $callback);
    }
    
    public function add($path, $callback, $method = 'GET')
    {
        $this->addRoute($method, $path, $callback);
    }
    
    private function addRoute($method, $path, $callback)
    {
        $this->routes[$method][$path] = $callback;
    }
    
    public function addMiddleware($path, $middleware)
    {
        $this->middlewares[$path] = $middleware;
    }
    
    public function dispatch($requestedPath, $requestMethod = 'GET')
    {
        // Extract the path from the full URL
        $path = parse_url($requestedPath, PHP_URL_PATH);
        
        // Remove the base directory part if needed
        $basePath = '/Arte_para_todos/public';
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }
        
        // Normalize the path
        $path = rtrim($path, '/');
        if (empty($path)) {
            $path = '/';
        }
        
        // Execute middleware if exists
        if (isset($this->middlewares[$path])) {
            $middleware = $this->middlewares[$path];
            if (is_callable($middleware)) {
                $middlewareResult = call_user_func($middleware);
                if ($middlewareResult === false) {
                    return; // Middleware blocked the request
                }
            }
        }
        
        // Check if the route exists for the given method
        if (isset($this->routes[$requestMethod][$path])) {
            $callback = $this->routes[$requestMethod][$path];
            $this->executeCallback($callback);
            return;
        }
        
        // Check for specific admin routes
        if ($path === '/admin') {
            $this->handleAdminRoute();
            return;
        }
        
        if (strpos($path, '/admin/') === 0) {
            $this->handleAdminSubRoutes($path, $requestMethod);
            return;
        }
        
        // 404 Not Found
        $this->handleNotFound($path);
    }
    
    private function executeCallback($callback)
    {
        try {
            if (is_array($callback) && count($callback) === 2) {
                // [Controller instance, method] format
                call_user_func($callback);
            } elseif (is_callable($callback)) {
                // Direct callable
                call_user_func($callback);
            } else {
                throw new \Exception('Invalid callback format');
            }
        } catch (\Exception $e) {
            error_log('Router error: ' . $e->getMessage());
            $this->handleInternalError($e);
        }
    }
    
    private function handleAdminRoute()
    {
        try {
            $adminController = new \ArtePT\Controllers\AdminController();
            $adminController->loginForm();
        } catch (\Exception $e) {
            error_log('Admin route error: ' . $e->getMessage());
            $this->handleInternalError($e);
        }
    }
    
    private function handleAdminSubRoutes($path, $method)
    {
        try {
            $adminController = new \ArtePT\Controllers\AdminController();
            
            switch ($path) {
                case '/admin/login':
                    if ($method === 'POST') {
                        $adminController->login();
                    } else {
                        $adminController->loginForm();
                    }
                    break;
                    
                case '/admin/dashboard':
                    $adminController->dashboard();
                    break;
                    
                case '/admin/upload-menu':
                    if ($method === 'POST') {
                        $adminController->uploadMenu();
                    } else {
                        $adminController->dashboard();
                    }
                    break;
                    
                case '/admin/logout':
                    $adminController->logout();
                    break;
                    
                default:
                    $this->handleNotFound($path);
            }
        } catch (\Exception $e) {
            error_log('Admin sub-route error: ' . $e->getMessage());
            $this->handleInternalError($e);
        }
    }
    
    private function handleNotFound($path)
    {
        http_response_code(404);
        if (file_exists(__DIR__ . '/../../error/404.html')) {
            include __DIR__ . '/../../error/404.html';
        } else {
            echo "<h1>404 Not Found</h1>";
            echo "<p>Path '{$path}' could not be found.</p>";
        }
    }
    
    private function handleInternalError($exception)
    {
        http_response_code(500);
        if (DEBUG) {
            echo "<h1>Internal Server Error</h1>";
            echo "<pre>" . $exception->getMessage() . "</pre>";
            echo "<pre>" . $exception->getTraceAsString() . "</pre>";
        } else {
            if (file_exists(__DIR__ . '/../../error/500.html')) {
                include __DIR__ . '/../../error/500.html';
            } else {
                echo "<h1>Internal Server Error</h1>";
                echo "<p>Something went wrong. Please try again later.</p>";
            }
        }
    }
    
    public function redirect($path, $statusCode = 302)
    {
        http_response_code($statusCode);
        header("Location: " . BASE_URL . "/public" . $path);
        exit;
    }
}
