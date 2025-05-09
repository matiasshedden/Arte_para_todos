<?php
// filepath: c:\xampp\htdocs\Arte_para_todos\database\connection.php

// Incluir la configuración
require_once __DIR__ . '/../config/config.php';

try {
    // Crear la conexión a la base de datos
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Manejo de errores
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Modo de fetch por defecto
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}