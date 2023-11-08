<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
// Incluir el archivo de conexión a la base de datos
include 'conexionDB.php';
global $con;

if (isset($_GET['id'])) {
    echo "Si entro al archivo";
    $id_jugador = $_GET['id'];
    $stmt = $con->prepare("DELETE FROM jugadores WHERE id_jugador = ?");
    $stmt->bind_param('i', $id_jugador);
    // Ejecutar la consulta de inserción
    if ($stmt->execute()) {
        header('Location: inicio.php?mensaje=El+Jugador+se+ha+eliminado+exitosamente.');
    } else {
        header('Location: inicio.php?error=Error+al+eliminar+los+datos:' . urlencode($stmt->error));
    }
    // Cierra la conexión y termina el script
    $stmt->close();
}
$con->close();

