<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: /Arte_para_todos/templates/login.twig');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="/Arte_para_todos/public/styles.css">
</head>
<body>
    <main class="container">
        <h2>Bienvenido, Administrador</h2>
        <!-- Contenido de administración aquí -->
        <a href="/Arte_para_todos/public/logout.php">Cerrar sesión</a>
    </main>
</body>
</html>
