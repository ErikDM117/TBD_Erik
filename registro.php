<?php
// Confirmar sesión
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
// Incluir el archivo de conexión a la base de datos
include 'conexionDB.php';
global $con;
// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $camiseta = $_POST['camiseta'];
    $equipo = $_POST['equipo'];
    $autor = $_SESSION['id_user']; // El autor toma el ID del usuario en sesión
    // Verificar si el jugador ya existe en la base de datos
    $stmt = $con->prepare("SELECT id_jugador FROM jugadores WHERE nombre = ? AND apellido = ? AND camiseta = ?");
    $stmt->bind_param('sss', $nombre, $apellido, $camiseta);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // El jugador ya existe, puedes mostrar un mensaje de error o realizar alguna acción adicional
        header('Location: inicio.php?error=El+jugador+ya+existe+en+la+base+de+datos.');
    } else {
        // El jugador no existe, procede a insertar los datos
        $stmt = $con->prepare("INSERT INTO jugadores (nombre, apellido, camiseta, equipo, autor) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssi', $nombre, $apellido, $camiseta, $equipo, $autor);
        // Ejecutar la consulta de inserción
        if ($stmt->execute()) {
            header('Location: inicio.php?mensaje=El+jugador+se+ha+registrado+exitosamente.');
        } else {
            header('Location: inicio.php?error=Error+al+guardar+los+datos:' . urlencode($stmt->error));
        }
    }
    // Cerrar la sentencia
    $stmt->close();
}
// Cerrar la conexión a la base de datos
$con->close();
