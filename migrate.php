<?php
/**
 * Database Migration Script
 * Execute this file to create the necessary database tables
 */

require_once 'database/connection.php';

try {
    // Read and execute the weekly_menu table migration
    $weeklyMenuSql = file_get_contents('database/migrations/create_table_weekly_menu.sql');
    $pdo->exec($weeklyMenuSql);
    echo "✅ Tabla 'weekly_menu' creada exitosamente\n";
    
    // Check if reserva table exists, if not create it
    try {
        $reservaSql = file_get_contents('database/migrations/create_table_reserva.sql');
        $pdo->exec($reservaSql);
        echo "✅ Tabla 'reserva' creada exitosamente\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'already exists') !== false) {
            echo "ℹ️  Tabla 'reserva' ya existe\n";
        } else {
            throw $e;
        }
    }
    
    // Check if admins table exists, if not create it
    try {
        $adminSql = file_get_contents('database/init_admin.sql');
        $pdo->exec($adminSql);
        echo "✅ Tabla 'admins' y usuario admin creados exitosamente\n";
        echo "   Usuario: admin | Contraseña: admin123\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'already exists') !== false || strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo "ℹ️  Usuario admin ya existe\n";
        } else {
            throw $e;
        }
    }
    
    echo "\n🎉 ¡Migración completada exitosamente!\n";
    echo "El sistema está listo para usar.\n";
    
} catch (Exception $e) {
    echo "❌ Error durante la migración: " . $e->getMessage() . "\n";
    exit(1);
}
