<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'peluqueria');
if ($mysqli->connect_error) {
    die('Error de conexión: Por favor, inténtalo más tarde.');
}

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['correo']) || !isset($_POST['codigo']) || !isset($_POST['nueva_contrasena'])) {
        echo "Faltan datos necesarios para actualizar la contraseña.";
        exit;
    }

    $correo = $_POST['correo'];
    $codigo = $_POST['codigo'];
    $nueva_contrasena = $_POST['nueva_contrasena'];

    if (empty($nueva_contrasena)) {
        echo "La nueva contraseña no puede estar vacía.";
        exit;
    }

    // Verificar que el código de recuperación sea válido
    $stmt = $mysqli->prepare("SELECT * FROM recuperacion WHERE correo_recuperacion = ? AND codigo_recuperacion = ?");
    $stmt->bind_param("ss", $correo, $codigo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // El código es válido, actualizar la contraseña
        $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);

        // Actualizar la contraseña del usuario
        $stmt = $mysqli->prepare("UPDATE clientes SET contrasena = ? WHERE correo = ?");
        $stmt->bind_param("ss", $nueva_contrasena_hash, $correo);
        $exito_actualizacion = $stmt->execute();

        if ($exito_actualizacion) {
            // Eliminar el código de recuperación usado
            $stmt = $mysqli->prepare("DELETE FROM recuperacion WHERE correo_recuperacion = ? AND codigo_recuperacion = ?");
            $stmt->bind_param("ss", $correo, $codigo);
            $stmt->execute();

            echo "Tu contraseña ha sido actualizada exitosamente.";
        } else {
            echo "Hubo un error al actualizar la contraseña. Por favor, inténtalo de nuevo.";
        }
    } else {
        echo "El código de recuperación no es válido o ha expirado. Por favor, solicita un nuevo código.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
