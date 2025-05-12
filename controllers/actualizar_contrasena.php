<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'peluqueria');
if ($mysqli->connect_error) {
    die('Conexión fallida: ' . $mysqli->connect_error);
}

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $codigo = $_POST['codigo'];
    $nueva_contrasena = $_POST['nueva_contrasena'];

    // Verificar que el código de recuperación sea válido
    $stmt = $mysqli->prepare("SELECT * FROM recuperacion WHERE correo_recuperacion = ? AND codigo_recuperacion = ?");
    $stmt->bind_param("ss", $correo, $codigo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // El código es válido, actualizar la contraseña
        $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);  // Usar hash para la contraseña

        // Actualizar la contraseña del usuario
        $stmt = $mysqli->prepare("UPDATE clientes SET contrasena = ? WHERE correo = ?");
        $stmt->bind_param("ss", $nueva_contrasena_hash, $correo);
        $stmt->execute();

        // Eliminar el código de recuperación usado
        $stmt = $mysqli->prepare("DELETE FROM recuperacion WHERE correo_recuperacion = ? AND codigo_recuperacion = ?");
        $stmt->bind_param("ss", $correo, $codigo);
        $stmt->execute();

        echo "Tu contraseña ha sido actualizada exitosamente.";
    } else {
        echo "El código de recuperación no es válido o ha expirado.";
    }
}
?>
