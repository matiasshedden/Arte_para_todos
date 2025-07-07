<?php

namespace ArtePT\Controllers;

use ArtePT\Core\BaseController;
use ArtePT\Models\Admin;
use ArtePT\Models\Menu;
use ArtePT\Models\Reservation;

class AdminController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function loginForm()
    {
        if ($this->isAuthenticated()) {
            $this->redirectTo('/admin/dashboard');
            return;
        }
        
        $data = [
            'title' => 'Admin Login - Arte para Todos',
            'base_url' => BASE_URL,
            'error' => $_SESSION['error'] ?? null
        ];
        
        unset($_SESSION['error']);
        
        return $this->render('admin_login.twig', $data);
    }
    
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('/admin');
            return;
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Por favor, complete todos los campos.';
            $this->redirectTo('/admin');
            return;
        }
        
        $adminModel = new Admin();
        if ($adminModel->authenticate($username, $password)) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            $this->redirectTo('/admin/dashboard');
        } else {
            $_SESSION['error'] = 'Credenciales incorrectas.';
            $this->redirectTo('/admin');
        }
    }
    
    public function dashboard()
    {
        if (!$this->isAuthenticated()) {
            $this->redirectTo('/admin');
            return;
        }
        
        $reservationModel = new Reservation();
        $menuModel = new Menu();
        
        $data = [
            'title' => 'Panel de Administración - Arte para Todos',
            'base_url' => BASE_URL,
            'admin_username' => $_SESSION['admin_username'],
            'reservations' => $reservationModel->getAllReservations(),
            'current_menu' => $menuModel->getCurrentWeekMenu(),
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ];
        
        unset($_SESSION['success'], $_SESSION['error']);
        
        return $this->render('admin_dashboard.twig', $data);
    }
    
    public function uploadMenu()
    {
        if (!$this->isAuthenticated()) {
            $this->redirectTo('/admin');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('/admin/dashboard');
            return;
        }
        
        $menuData = [
            'week_start' => $_POST['week_start'] ?? '',
            'week_end' => $_POST['week_end'] ?? '',
            'menu_items' => $_POST['menu_items'] ?? '',
            'special_notes' => $_POST['special_notes'] ?? ''
        ];
        
        // Validación básica
        if (empty($menuData['week_start']) || empty($menuData['week_end']) || empty($menuData['menu_items'])) {
            $_SESSION['error'] = 'Por favor, complete todos los campos obligatorios.';
            $this->redirectTo('/admin/dashboard');
            return;
        }
        
        try {
            $menuModel = new Menu();
            $menuModel->createWeekMenu($menuData);
            $_SESSION['success'] = 'Menú de la semana actualizado correctamente.';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al actualizar el menú: ' . $e->getMessage();
            error_log('Error al actualizar menú: ' . $e->getMessage());
        }
        
        $this->redirectTo('/admin/dashboard');
    }
    
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        $this->redirectTo('/');
    }
    
    private function isAuthenticated()
    {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
}
