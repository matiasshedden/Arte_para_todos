<?php
/**
 * System Check Script
 * Verifies that all components are working correctly
 */

echo "🔍 Verificando sistema Arte para Todos...\n\n";

// Check PHP version
echo "📋 Verificaciones básicas:\n";
echo "   PHP Version: " . PHP_VERSION;
if (version_compare(PHP_VERSION, '7.4.0', '>=')) {
    echo " ✅\n";
} else {
    echo " ❌ (Requiere PHP 7.4+)\n";
}

// Check required extensions
$required_extensions = ['pdo', 'pdo_mysql', 'json', 'mbstring'];
foreach ($required_extensions as $ext) {
    echo "   Extension $ext: " . (extension_loaded($ext) ? "✅" : "❌") . "\n";
}

// Check Composer autoloader
echo "\n📦 Composer:\n";
if (file_exists('vendor/autoload.php')) {
    echo "   Autoloader: ✅\n";
    require_once 'vendor/autoload.php';
} else {
    echo "   Autoloader: ❌ (Ejecuta 'composer install')\n";
    exit(1);
}

// Check configuration
echo "\n⚙️  Configuración:\n";
if (file_exists('.env')) {
    echo "   Archivo .env: ✅\n";
} else {
    echo "   Archivo .env: ❌ (Copia .env.example a .env)\n";
}

if (file_exists('config/config.php')) {
    echo "   Config file: ✅\n";
    require_once 'config/config.php';
} else {
    echo "   Config file: ❌\n";
    exit(1);
}

// Check database connection
echo "\n🗄️  Base de datos:\n";
try {
    require_once 'database/connection.php';
    global $pdo;
    echo "   Conexión: ✅\n";
    
    // Check tables
    $tables = ['reserva', 'weekly_menu', 'admins'];
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT 1 FROM $table LIMIT 1");
            echo "   Tabla $table: ✅\n";
        } catch (Exception $e) {
            echo "   Tabla $table: ❌ (Ejecuta 'php migrate.php')\n";
        }
    }
} catch (Exception $e) {
    echo "   Conexión: ❌ (" . $e->getMessage() . ")\n";
}

// Check file structure
echo "\n📁 Estructura de archivos:\n";
$required_dirs = [
    'public',
    'src/Controllers',
    'src/Models', 
    'src/Core',
    'templates',
    'database',
    'storage/logs',
    'storage/cache'
];

foreach ($required_dirs as $dir) {
    echo "   $dir: " . (is_dir($dir) ? "✅" : "❌") . "\n";
}

// Check key files
$required_files = [
    'public/index.php',
    'src/Controllers/HomeController.php',
    'src/Controllers/AdminController.php',
    'src/Core/Router.php',
    'src/Core/BaseController.php',
    'templates/home.twig',
    'templates/admin_login.twig',
    'templates/admin_dashboard.twig'
];

foreach ($required_files as $file) {
    echo "   $file: " . (file_exists($file) ? "✅" : "❌") . "\n";
}

// Check write permissions
echo "\n✍️  Permisos de escritura:\n";
$writable_dirs = ['storage/logs', 'storage/cache'];
foreach ($writable_dirs as $dir) {
    if (is_dir($dir)) {
        echo "   $dir: " . (is_writable($dir) ? "✅" : "❌") . "\n";
    }
}

echo "\n🌐 URLs del sistema:\n";
echo "   Sitio principal: " . BASE_URL . "/public/\n";
echo "   Panel admin: " . BASE_URL . "/public/admin\n";

echo "\n🔐 Credenciales admin por defecto:\n";
echo "   Usuario: admin\n";
echo "   Contraseña: admin123\n";

echo "\n✨ ¡Verificación completa!\n";
echo "\nPara iniciar el servidor de desarrollo:\n";
echo "   php -S localhost:8000 -t public\n";
echo "\nO accede a: http://localhost/Arte_para_todos/public/\n";
