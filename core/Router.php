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
        
        // Normalize the path
        $path = rtrim($path, '/'); // Remove trailing slash
        if (empty($path)) {
            $path = '/';
        }

        // Check if the route exists
        if (array_key_exists($path, $this->routes)) {
            $callback = $this->routes[$path];

            if (is_array($callback) && count($callback) === 2 && is_string($callback[0]) && is_string($callback[1])) {
                // Potential ['ClassName', 'methodName'] callback
                $className = $callback[0];
                $methodName = $callback[1];

                // Construct file path from class name (e.g., App\Controllers\AdminController -> app/controllers/AdminController.php)
                // This assumes a base directory structure where this Router.php is in 'core/'
                // and controllers are in 'app/controllers/' relative to the project root.
                // The str_replace handles namespaces.
                $controllerFileName = str_replace('\\', '/', $className) . '.php'; // Converts App\Controllers\MyController to App/Controllers/MyController.php
                $controllerFilePath = __DIR__ . '/../' . str_replace('App/Controllers/', 'app/controllers/', $controllerFileName); // Adjust base path

                if (file_exists($controllerFilePath)) {
                    require_once $controllerFilePath;
                    if (class_exists($className)) {
                        $controllerInstance = new $className();
                        if (method_exists($controllerInstance, $methodName)) {
                            call_user_func([$controllerInstance, $methodName]);
                        } else {
                            http_response_code(500);
                            echo "500 Internal Server Error - Method '{$methodName}' not found in controller '{$className}'.";
                        }
                    } else {
                        http_response_code(500);
                        echo "500 Internal Server Error - Class '{$className}' not found in file '{$controllerFilePath}'.";
                    }
                } else {
                    http_response_code(500);
                    echo "500 Internal Server Error - Controller file '{$controllerFilePath}' not found.";
                }
            } elseif (is_callable($callback)) {
                // Existing callable (e.g., anonymous function, or [new Object(), 'method'])
                call_user_func($callback);
            } else {
                http_response_code(500);
                echo "500 Internal Server Error - Invalid callback for path '{$path}'.";
            }
        } else {
            http_response_code(404);
            echo "404 Not Found - Path '{$path}' could not be found.";
        }
    }
}
?>