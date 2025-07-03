<?php
require_once 'vendor/autoload.php';
// ...configuración Twig...
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
    $producto = $_POST['producto'];
    $imagen = $_FILES['imagen'];

    // Guardar la imagen en el servidor
    $destino = 'uploads/' . basename($imagen['name']);
    if (move_uploaded_file($imagen['tmp_name'], $destino)) {
        // Aquí deberías guardar la ruta de la imagen en la base de datos
        // Ejemplo:
        // $pdo = new PDO(...);
        // $stmt = $pdo->prepare("UPDATE menu SET imagen = ? WHERE producto = ?");
        // $stmt->execute([$destino, $producto]);

        echo $twig->render('mensaje.twig', [
            'mensaje' => "Imagen subida correctamente para $producto."
        ]);
    } else {
        echo $twig->render('mensaje.twig', [
            'mensaje' => "Error al subir la imagen."
        ]);
    }
} else {
    echo $twig->render('mensaje.twig', [
        'mensaje' => "Acceso no permitido."
    ]);
}
