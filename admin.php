<?php
// Aquí puedes agregar validación de sesión/admin si es necesario
// session_start();
// if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Administración del Menú</title>
</head>
<body>
    <h1>Administración del Menú</h1>
    <form action="procesar_precio.php" method="post">
        <h2>Actualizar Precios</h2>
        Nombre del producto: <input type="text" name="producto" required><br>
        Nuevo precio: <input type="number" step="0.01" name="precio" required><br>
        <input type="submit" value="Actualizar Precio">
    </form>
    <hr>
    <form action="procesar_imagen.php" method="post" enctype="multipart/form-data">
        <h2>Subir Imagen de Menú</h2>
        Nombre del producto: <input type="text" name="producto" required><br>
        Imagen: <input type="file" name="imagen" accept="image/*" required><br>
        <input type="submit" value="Subir Imagen">
    </form>
</body>
</html>
