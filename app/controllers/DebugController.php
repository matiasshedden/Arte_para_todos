<?php
// filepath: c:\xampp\htdocs\Arte_para_todos\app\controllers\DebugController.php

class DebugController {
    public function index() {
        // Verificar si DEBUG está habilitado
        if (defined('DEBUG') && DEBUG) {
            ob_start();
            include __DIR__ . '/../../public/debug.php'; // Incluir el archivo de depuración
            $debugContent = ob_get_clean();

            // Test de conexión a la base de datos
            $dbTestResult = '';
            try {
                require_once __DIR__ . '/../../database/connection.php';
                $dbTestResult = 'Connection successful to base de datos: ' . DB_NAME;
            } catch (Exception $e) {
                $dbTestResult = 'Database connection failed: ' . $e->getMessage();
            }

            // Renderizar la vista con Twig
            require_once __DIR__ . '/../views/DebugView.php';
            DebugView::render([
                'debugContent' => $debugContent,
                'dbTestResult' => $dbTestResult
            ]);
        } else {
            http_response_code(403);
            echo 'Acceso denegado. El modo de depuración está deshabilitado.';
        }
    }
}