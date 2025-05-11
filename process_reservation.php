<?php
require_once 'database/queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['name'] ?? '';
    $telefono = $_POST['tel'] ?? '';
    $fecha = $_POST['date'] ?? '';
    $hora = $_POST['time'] ?? '';
    $nro_personas = $_POST['nro_personas'] ?? 0;

    if (!empty($nombre) && !empty($telefono) && !empty($fecha) && !empty($hora) && $nro_personas > 0) {
        try {
            insertarReserva($nombre, $telefono, $fecha, $hora, $nro_personas);
            echo "Reserva realizada con éxito.";
        } catch (Exception $e) {
            echo "Error al realizar la reserva. Por favor, intente nuevamente.";
        }
    } else {
        echo "Por favor, complete todos los campos correctamente.";
    }
} else {
    echo "Método no permitido.";
}
?>
