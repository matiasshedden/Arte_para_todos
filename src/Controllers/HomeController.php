<?php

namespace ArtePT\Controllers;

use ArtePT\Core\BaseController;
use ArtePT\Models\Menu;

class HomeController extends BaseController
{
    public function index()
    {
        $menuModel = new Menu();
        $currentMenu = $menuModel->getCurrentWeekMenu();
        
        $data = [
            'title' => 'Bienvenidos a Arte para Todos',
            'base_url' => BASE_URL,
            'current_menu' => $currentMenu
        ];
        
        return $this->render('home.twig', $data);
    }
    
    public function processReservation()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('/');
            return;
        }
        
        $nombre = $_POST['name'] ?? '';
        $telefono = $_POST['tel'] ?? '';
        $fecha = $_POST['date'] ?? '';
        $hora = $_POST['time'] ?? '';
        $nro_personas = intval($_POST['nro_personas'] ?? 0);
        
        // Validación básica
        if (empty($nombre) || empty($telefono) || empty($fecha) || empty($hora) || $nro_personas <= 0) {
            $this->flashMessage('error', 'Por favor, complete todos los campos correctamente.');
            $this->redirectTo('/');
            return;
        }
        
        try {
            require_once __DIR__ . '/../../database/queries.php';
            insertarReserva($nombre, $telefono, $fecha, $hora, $nro_personas);
            $this->flashMessage('success', '¡Reserva realizada con éxito! Nos contactaremos con usted pronto.');
        } catch (Exception $e) {
            $this->flashMessage('error', 'Error al realizar la reserva. Por favor, intente nuevamente.');
            error_log('Error en reserva: ' . $e->getMessage());
        }
        
        $this->redirectTo('/');
    }
}
