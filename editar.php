<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Jugador</title>
</head>
<body>
    <h1>Actualizar Jugador</h1>
    
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
        // Conecta a la base de datos (debes proporcionar tus propios datos de conexión).
        // Verifica si la conexión es exitosa.
        if ($con->connect_error) {
            die("Error de conexión a la base de datos: " . $con->connect_error);
        }
        
        $id_jugador = $_GET['id'];
        
        // Realiza una consulta para obtener los datos del jugador según el ID.
        $query = "SELECT * FROM jugadores WHERE id_jugador = '$id_jugador'";
        $result = $con->query($query);
        
        if ($result->num_rows > 0) {
            $jugador = $result->fetch_assoc();
            echo '<h2>Datos del Jugador</h2>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="idJugador" value="' . $jugador['id_jugador'] . '">';
            echo '<label for="nombre">Nombre:</label>';
            echo '<input type="text" id="nombre" name="nombre" value="' . $jugador['nombre'] . '" required>';
            echo '<label for="apellido">Apellido:</label>';
            echo '<input type="text" id="apellido" name="apellido" value="' . $jugador['apellido'] . '" required>';
            echo '<label for="camiseta">Camiseta:</label>';
            echo '<input type="text" id="camiseta" name="camiseta" value="' . $jugador['camiseta'] . '" required>';
            echo '<label for="equipo">Equipo:</label>';
            echo '<input type="text" id="equipo" name="equipo" value="' . $jugador['equipo'] . '" required>';
            echo '<label for="autor">Autor:</label>';
            echo '<input type="text" id="autor" name="autor" value="' . $jugador['autor'] . '" required>';
            echo '<input type="submit" value="Actualizar Jugador" name="actualizarJugador">';
            echo '</form>';
        } else {
            echo "No se encontraron datos para el jugador proporcionado.";
        }
    }
    
    if (isset($_POST['actualizarJugador'])) {
        // Conecta a la base de datos nuevamente.
        // Verifica si la conexión es exitosa.
        if ($con->connect_error) {
            die("Error de conexión a la base de datos: " . $con->connect_error);
        }
        
        $idJugador = $_POST['idJugador'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $camiseta = $_POST['camiseta'];
        $equipo = $_POST['equipo'];
        $autor = $_POST['autor'];

        // Realiza una consulta para actualizar el registro en la base de datos.
        $query = "UPDATE jugadores SET nombre = '$nombre', apellido = '$apellido', camiseta = '$camiseta', equipo = '$equipo', autor = '$autor' WHERE id_jugador = $idJugador";
        
        if ($con->query($query) === TRUE) {
            header("Location: inicio.php?mensaje=El+jugador+" . urlencode($nombre) . "+se+ha+actualizado+exitosamente.");
        } else {
            header('Location: inicio.php?error=Error+al+actualizar+los+datos:' . urlencode($stmt->error));
        }
    }
    
    $con->close();
    ?>
</body>
</html>
