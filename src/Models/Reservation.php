<?php

namespace ArtePT\Models;

use PDO;
use PDOException;

class Reservation
{
    private $db;
    
    public function __construct()
    {
        $this->initializeDatabase();
    }
    
    private function initializeDatabase()
    {
        // Cargar configuración
        require_once __DIR__ . '/../../config/config.php';
        
        try {
            // Crear conexión directa
            $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Error al conectar con la base de datos: ' . $e->getMessage());
        }
    }
    
    public function getAllReservations()
    {
        $sql = "SELECT * FROM reserva ORDER BY fecha DESC, hora DESC";
        
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener reservas: ' . $e->getMessage());
            return [];
        }
    }
    
    public function getReservationsByDate($date)
    {
        $sql = "SELECT * FROM reserva WHERE fecha = :fecha ORDER BY hora ASC";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':fecha' => $date]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener reservas por fecha: ' . $e->getMessage());
            return [];
        }
    }
    
    public function getUpcomingReservations($limit = 10)
    {
        $sql = "SELECT * FROM reserva 
                WHERE fecha >= CURDATE() 
                ORDER BY fecha ASC, hora ASC 
                LIMIT :limit";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener próximas reservas: ' . $e->getMessage());
            return [];
        }
    }
    
    public function createReservation($data)
    {
        $sql = "INSERT INTO reserva (nombre, telefono, fecha, hora, nro_personas) 
                VALUES (:nombre, :telefono, :fecha, :hora, :nro_personas)";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nombre' => $data['nombre'],
                ':telefono' => $data['telefono'],
                ':fecha' => $data['fecha'],
                ':hora' => $data['hora'],
                ':nro_personas' => $data['nro_personas']
            ]);
        } catch (PDOException $e) {
            throw new \Exception('Error al crear reserva: ' . $e->getMessage());
        }
    }
    
    public function updateReservation($id, $data)
    {
        $sql = "UPDATE reserva 
                SET nombre = :nombre, telefono = :telefono, fecha = :fecha, 
                    hora = :hora, nro_personas = :nro_personas 
                WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':nombre' => $data['nombre'],
                ':telefono' => $data['telefono'],
                ':fecha' => $data['fecha'],
                ':hora' => $data['hora'],
                ':nro_personas' => $data['nro_personas']
            ]);
        } catch (PDOException $e) {
            throw new \Exception('Error al actualizar reserva: ' . $e->getMessage());
        }
    }
    
    public function deleteReservation($id)
    {
        $sql = "DELETE FROM reserva WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar reserva: ' . $e->getMessage());
        }
    }
    
    public function getReservationById($id)
    {
        $sql = "SELECT * FROM reserva WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener reserva por ID: ' . $e->getMessage());
            return null;
        }
    }
    
    public function getReservationStats()
    {
        $sql = "SELECT 
                    COUNT(*) as total_reservas,
                    COUNT(CASE WHEN fecha >= CURDATE() THEN 1 END) as reservas_futuras,
                    COUNT(CASE WHEN fecha = CURDATE() THEN 1 END) as reservas_hoy,
                    SUM(nro_personas) as total_personas
                FROM reserva";
        
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener estadísticas: ' . $e->getMessage());
            return [
                'total_reservas' => 0,
                'reservas_futuras' => 0,
                'reservas_hoy' => 0,
                'total_personas' => 0
            ];
        }
    }
}
