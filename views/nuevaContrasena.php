<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Conexión a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'peluqueria');
if ($mysqli->connect_error) {
    die('Conexión fallida: ' . $mysqli->connect_error);
}

// 2. Procesar el formulario si se envió
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["correo"], $_POST["codigo"], $_POST["nueva_contrasena"])) {
        $correo = $_POST["correo"];
        $codigo = $_POST["codigo"];
        $nueva_contrasena = $_POST["nueva_contrasena"];

        if (!empty($nueva_contrasena)) {
            $passwordHash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

            // Actualizar la contraseña
            $stmt = $mysqli->prepare("UPDATE usuarios SET contrasena = ? WHERE correo = ?");
            $stmt->bind_param("ss", $passwordHash, $correo);
            $stmt->execute();

            // Eliminar el código de recuperación
            $stmt = $mysqli->prepare("DELETE FROM recuperacion WHERE correo_recuperacion = ?");
            $stmt->bind_param("s", $correo);
            $stmt->execute();

            echo "Tu contraseña ha sido actualizada exitosamente.";
            exit;
        } else {
            echo "Error: La nueva contraseña no puede estar vacía.";
            exit;
        }
    } else {
        echo "Error: Faltan datos del formulario.";
        exit;
    }
}

// 3. Mostrar formulario si se accede con GET y parámetros válidos
if (isset($_GET['correo']) && isset($_GET['codigo'])) {
    $correo = $_GET['correo'];
    $codigo = $_GET['codigo'];

    $stmt = $mysqli->prepare("SELECT * FROM recuperacion WHERE correo_recuperacion = ? AND codigo_recuperacion = ?");
    $stmt->bind_param("ss", $correo, $codigo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Formulario Nueva Contraseña</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="../../assets/css/estilo.css">
        </head>
        <body>
            <header class="text-center py-4" style="background-color: #111; color: gold;">
                <h1>Estilos Dairo</h1>
                <p>¡Crea tu cuenta y reserva con estilo!</p>
            </header>

            <nav class="d-flex justify-content-center gap-4 py-3" style="background-color: #222;">
                <a href="./index.php" style="color: gold; text-decoration: none;">Inicio</a>
                <a href="./productos.php" style="color: gold; text-decoration: none;">Productos</a>
                <a href="./agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
            </nav>

            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="bg-white p-4 rounded shadow">
                            <h2 class="text-center mb-4" style="color: goldenrod;">Recuperar Contraseña</h2>
                            <form action="../controllers/actualizar_contrasena.php" method="POST" class="form-actualizar">
                                <input type="hidden" name="correo" value="<?php echo htmlspecialchars($correo); ?>">
                                <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">
                                <div class="mb-3">
                                    <label for="nueva_contrasena">Nueva Contraseña:</label>
                                    <input type="password" name="nueva_contrasena" id="nueva_contrasena" class="form-control" required>
                                </div>
                                <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-dark px-4" style="background-color: goldenrod; border: none;">Actualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>            
        </body>
        </html>
        <?php
    } else {
        echo "El enlace de recuperación ha expirado o es inválido.";
    }
} else {
    echo "Faltan los parámetros necesarios.";
}
?>