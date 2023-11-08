<?php
// confirmar sesion
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="loggedin">
    <nav class="navtop">
        <div class="header">
            <h1 style="color:white; margin-right: 20px;">PartiTech</h1>
            <div class="nav-links">
                <a href="listagrupos.php" class="nav-link">Equipos</a>
                <a href="perfil.php" class="nav-link">Perfil</a>
                <a href="cerrar-sesion.php" class="nav-link">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="content">
        <h2>Jugadores que hicieron grande a Leo Messi</h2>
        <!-- Formulario para insertar datos en la tabla students con diseño Bootstrap -->
        <?php
        if (isset($_GET['mensaje'])) {
            echo "<p style='color: green;'>" . $_GET['mensaje'] . "</p>";
        }
        if (isset($_GET['error'])) {
            echo "<p style='color: red;'>" . $_GET['error'] . "</p>";
        }
        ?>
        <form method="POST" action="registro.php" class="form-horizontal">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Nombre:</th>
                    <th>Apellido:</th>
                    <th>camiseta:</th>
                    <th>Equipo:</th>
                    <th>Enviar</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="text" class="form-control" name="nombre" required></td>
                    <td><input type="text" class="form-control" name="apellido" required></td>
                    <td><input type="text" class="form-control" name="camiseta" required></td>
                    <td><input type="text" class="form-control" name="equipo" required></td>
                    <td><input type="submit" class="btn btn-primary" value="Guardar"></td>
                </tr>
                </tbody>
            </table>
        </form>
        <!-- Mostrar la tabla de estudiantes -->
        <h3>Tabla de Jugadores</h3>
        <?php
        // Aquí debes obtener y mostrar los datos de la tabla students
        // Conectar a la base de datos (incluye tu archivo de conexión)
        include 'conexionDB.php';
        global $con;
        // Consulta SQL para obtener todos los registros de students
        $sql = "SELECT * FROM jugadores";
        $result = $con->query($sql);
        // Verificar si la tabla está vacía
        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Id Jugador</th>";
            echo "<th>Nombres</th>";
            echo "<th>Apellido</th>";
            echo "<th>Camiseta</th>";
            echo "<th>Equipo</th>";
            echo "<th>Autor</th>";
            echo "<th>Acciones</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id_jugador']}</td>";
                echo "<td>{$row['nombre']}</td>";
                echo "<td>{$row['apellido']}</td>";
                echo "<td>{$row['camiseta']}</td>";
                echo "<td>{$row['equipo']}</td>";
                // Obtener el nombre del profesor utilizando el ID almacenado en $row['prof_autor']
                $autor = $row['autor'];
                $query = "SELECT username FROM cuentas WHERE id_user = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('i', $profesorID);
                $stmt->execute();
                $stmt->bind_result($nombreProfesor);
                $stmt->fetch();
                $stmt->close();
                echo "<td>{$autor}</td>";
                echo "<td><a href='editar.php?id={$row['id_jugador']}'><img src='btneditar.png' alt='Editar'></a>   <a href='eliminar.php?id={$row['id_jugador']}'><img src='btneliminar.png' alt='Eliminar'></a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No hay registros en la tabla de Jugadores.</p>";
        }
        // Cerrar la consulta
        $result->close();
        ?>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
