<?php
require_once 'vendor/autoload.php';
// ...configuración Twig...
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];

    // Aquí deberías actualizar el precio en la base de datos
    // Ejemplo:
    // $pdo = new PDO(...);
    // $stmt = $pdo->prepare("UPDATE menu SET precio = ? WHERE producto = ?");
    // $stmt->execute([$precio, $producto]);

    echo $twig->render('mensaje.twig', [
        'mensaje' => "Precio actualizado correctamente para $producto."
    ]);
} else {
    echo $twig->render('mensaje.twig', [
        'mensaje' => "Acceso no permitido."
    ]);
}
