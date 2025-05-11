<?php
// filepath: c:\xampp\htdocs\Arte_para_todos\app\controllers\DebugController.php
require_once __DIR__ . '/../../database/queries.php';

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

            // Obtener reservas ANTES de renderizar la vista
            $reservas = obtenerReservas();

            // Renderizar la vista con Twig
            require_once __DIR__ . '/../views/DebugView.php';
            DebugView::render([
                'debugContent' => $debugContent,
                'dbTestResult' => $dbTestResult,
                'reservas' => $reservas
            ]);
        } else {
            http_response_code(403);
            echo 'Acceso denegado. El modo de depuración está deshabilitado.';
        }
    }
}