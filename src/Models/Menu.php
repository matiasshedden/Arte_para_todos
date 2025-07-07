<?php

namespace ArtePT\Models;

use PDO;
use PDOException;

class Menu
{
    private $db;
    
    public function __construct()
    {
        $this->db = $this->getConnection();
    }
    
    private function getConnection()
    {
        // Incluir la configuración
        require_once __DIR__ . '/../../config/config.php';
        
        try {
            // Crear la conexión a la base de datos
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            error_log("Error al conectar con la base de datos: " . $e->getMessage());
            throw new \Exception("Error de conexión a la base de datos");
        }
    }
    
    public function getCurrentWeekMenu()
    {
        // Add logging for debugging
        error_log('Menu::getCurrentWeekMenu() called');
        
        if ($this->db === null) {
            error_log('Database connection is null in getCurrentWeekMenu()');
            return null;
        }
        
        $sql = "SELECT * FROM weekly_menu 
                WHERE week_start <= CURDATE() AND week_end >= CURDATE() 
                ORDER BY created_at DESC LIMIT 1";
        
        try {
            error_log('Executing query: ' . $sql);
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log('Query result: ' . ($result ? 'Found' : 'Not found'));
            return $result;
        } catch (PDOException $e) {
            error_log('Error al obtener menú actual: ' . $e->getMessage());
            return null;
        }
    }
    
    public function createWeekMenu($menuData)
    {
        // First, deactivate any existing menu for overlapping dates
        $this->deactivateOverlappingMenus($menuData['week_start'], $menuData['week_end']);
        
        $sql = "INSERT INTO weekly_menu (week_start, week_end, menu_items, special_notes, created_at) 
                VALUES (:week_start, :week_end, :menu_items, :special_notes, NOW())";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':week_start' => $menuData['week_start'],
                ':week_end' => $menuData['week_end'],
                ':menu_items' => $menuData['menu_items'],
                ':special_notes' => $menuData['special_notes']
            ]);
        } catch (PDOException $e) {
            throw new \Exception('Error al crear menú semanal: ' . $e->getMessage());
        }
    }
    
    public function getAllMenus()
    {
        $sql = "SELECT * FROM weekly_menu ORDER BY week_start DESC";
        
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener todos los menús: ' . $e->getMessage());
            return [];
        }
    }
    
    public function deleteMenu($id)
    {
        $sql = "DELETE FROM weekly_menu WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar menú: ' . $e->getMessage());
        }
    }
    
    private function deactivateOverlappingMenus($startDate, $endDate)
    {
        $sql = "DELETE FROM weekly_menu 
                WHERE (week_start BETWEEN :start_date AND :end_date) 
                   OR (week_end BETWEEN :start_date AND :end_date)
                   OR (week_start <= :start_date AND week_end >= :end_date)";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':start_date' => $startDate,
                ':end_date' => $endDate
            ]);
        } catch (PDOException $e) {
            error_log('Error al desactivar menús superpuestos: ' . $e->getMessage());
        }
    }
    
    public function getMenuByWeek($weekStart)
    {
        $sql = "SELECT * FROM weekly_menu WHERE week_start = :week_start";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':week_start' => $weekStart]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener menú por semana: ' . $e->getMessage());
            return null;
        }
    }
}
