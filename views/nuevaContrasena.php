<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'peluqueria');
if ($mysqli->connect_error) {
    die('Conexión fallida: ' . $mysqli->connect_error);
}

// Verifica si los parámetros 'correo' y 'codigo' están en la URL
if (isset($_GET['correo']) && isset($_GET['codigo'])) {
    $correo = $_GET['correo'];
    $codigo = $_GET['codigo'];

    // Verifica que el código de recuperación sea válido
    $stmt = $mysqli->prepare("SELECT * FROM recuperacion WHERE correo_recuperacion = ? AND codigo_recuperacion = ?");
    $stmt->bind_param("ss", $correo, $codigo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // El código es válido, muestra el formulario para cambiar la contraseña
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cambiar Contraseña</title>
        </head>
        <body>
            <h2>Recuperación de Contraseña</h2>
            <form action="actualizarContrasena.php" method="POST">
                <input type="hidden" name="correo" value="<?php echo htmlspecialchars($correo); ?>">
                <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">

                <label for="nueva_contrasena">Nueva Contraseña:</label><br>
                <input type="password" name="contrasena" id="contrasena" required><br><br>

                <button type="submit">Actualizar Contraseña</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        // El código no es válido
        echo "El enlace de recuperación ha expirado o es inválido.";
    }
} else {
    echo "Faltan los parámetros necesarios.";
}
?>
