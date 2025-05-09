<?php
class Router {
    private $routes = [];

    // Add a route to the router
    public function add($path, $callback) {
        $this->routes[$path] = $callback;
    }

    // Dispatch the request to the appropriate route
    public function dispatch($requestedPath) {
        // Extract the path from the full URL
        $path = parse_url($requestedPath, PHP_URL_PATH);
        
        // Remove the base directory part if needed
        $basePath = '/Arte_para_todos/public';
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }
        
        // Ensure we have at least '/' as the path
        if (empty($path)) {
            $path = '/';
        }

        // Check if the route exists
        if (array_key_exists($path, $this->routes)) {
            // Handle both function callbacks and [object, method] arrays
            if (is_array($this->routes[$path])) {
                call_user_func($this->routes[$path]);
            } else {
                call_user_func($this->routes[$path]);
            }
        } else {
            http_response_code(404);
            echo "404 Not Found - Path '{$path}' could not be found.";
        }
    }
}
?>