<?php
// Configuration file
// filepath: c:\xampp\htdocs\Arte_para_todos\config\config.php

// Base URL of the application
define('BASE_URL', 'http://localhost/Arte_para_todos');

// Cambiar a false en producción
define('DEBUG', getenv('DEBUG') !== false ? (bool)getenv('DEBUG') : true);

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'arte_para_todos');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
?>