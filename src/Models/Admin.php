<?php

namespace ArtePT\Models;

use PDO;
use PDOException;

class Admin
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
    
    public function authenticate($username, $password)
    {
        $sql = "SELECT id, username, password_hash FROM admins WHERE username = :username";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':username' => $username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($admin && password_verify($password, $admin['password_hash'])) {
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            error_log('Error en autenticación: ' . $e->getMessage());
            return false;
        }
    }
    
    public function createAdmin($username, $password)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO admins (username, password_hash) VALUES (:username, :password_hash)";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':username' => $username,
                ':password_hash' => $passwordHash
            ]);
        } catch (PDOException $e) {
            throw new \Exception('Error al crear administrador: ' . $e->getMessage());
        }
    }
    
    public function updatePassword($username, $newPassword)
    {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE admins SET password_hash = :password_hash WHERE username = :username";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':username' => $username,
                ':password_hash' => $passwordHash
            ]);
        } catch (PDOException $e) {
            throw new \Exception('Error al actualizar contraseña: ' . $e->getMessage());
        }
    }
    
    public function getAdminByUsername($username)
    {
        $sql = "SELECT id, username FROM admins WHERE username = :username";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':username' => $username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener admin: ' . $e->getMessage());
            return null;
        }
    }
}
