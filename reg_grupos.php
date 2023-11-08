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
    $nombre_equipo = $_POST['nombre_equipo'];
    $director_tec = $_POST['director_tec'];
    $numero_jug = $_POST['numero_jug'];
    
    // Asegúrate de que la clave correcta sea 'id_user' o la que corresponda en $_SESSION
    $autor = $_SESSION['id_user']; // El profesor autor toma el ID del usuario en sesión

    // Preparar la consulta SQL para insertar datos en la tabla equipos
    $sql = "INSERT INTO equipos (nombre_equipo, director_tec, numero_jug, autor) VALUES (?, ?, ?, ?)";
    
    // Preparar la sentencia SQL
    $stmt = $con->prepare($sql);
    
    // Vincular los parámetros
    $stmt->bind_param('ssii', $nombre_equipo, $director_tec, $numero_jug, $autor);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        header('Location: listagrupos.php?mensaje=El+equipo+se+ha+agregado+exitosamente.');
    } else {
        header('Location: listagrupos.php?error=Error+al+agregar+al+grupo:+' . urlencode($stmt->error));
    }
    
    // Cerrar la sentencia
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$con->close();
