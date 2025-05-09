<?php
// filepath: c:\xampp\htdocs\Arte_para_todos\database\queries.php

require_once 'connection.php';

// Función para insertar una reserva
function insertarReserva($dni, $nombre, $telefono, $fecha, $hora, $nro_personas) {
    global $pdo;

    $sql = "INSERT INTO reserva (dni, nombre, telefono, fecha, hora, nro_personas) 
            VALUES (:dni, :nombre, :telefono, :fecha, :hora, :nro_personas)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':dni' => $dni,
        ':nombre' => $nombre,
        ':telefono' => $telefono,
        ':fecha' => $fecha,
        ':hora' => $hora,
        ':nro_personas' => $nro_personas
    ]);
}