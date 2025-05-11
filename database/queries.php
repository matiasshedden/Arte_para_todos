<?php
// filepath: c:\xampp\htdocs\Arte_para_todos\database\queries.php

require_once 'connection.php';

// Función para insertar una reserva
function insertarReserva($nombre, $telefono, $fecha, $hora, $nro_personas) {
    global $pdo;

    $sql = "INSERT INTO reserva (nombre, telefono, fecha, hora, nro_personas) 
            VALUES (:nombre, :telefono, :fecha, :hora, :nro_personas)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':nombre' => $nombre,
            ':telefono' => $telefono,
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':nro_personas' => $nro_personas
        ]);
    } catch (PDOException $e) {
        // Manejo de errores
        throw new Exception("Error al insertar la reserva: " . $e->getMessage());
    }
}

// Función para recuperar todas las reservas
function obtenerReservas() {
    global $pdo;

    $sql = "SELECT * FROM reserva ORDER BY fecha DESC, hora DESC";
    try {
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error al obtener las reservas: " . $e->getMessage());
    }
}