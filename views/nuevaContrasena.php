<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - Estilos Dairo</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Iconos (opcional si ya lo usas) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="../../assets/css/estilo.css">
</head>
<body class="fondo" style="background-color: #f8f8f8;">

    <!-- Header -->
    <header class="text-center py-4" style="background-color: #111; color: gold;">
        <h1>Estilos Dairo</h1>
        <p>¡Crea tu cuenta y reserva con estilo!</p>
    </header>

    <!-- Navbar -->
    <nav class="d-flex justify-content-center gap-4 py-3" style="background-color: #222;">
        <a href="./index.php" class="text-decoration-none" style="color: gold;">Inicio</a>
        <a href="./productos.php" class="text-decoration-none" style="color: gold;">Productos</a>
        <a href="./agendarCita.php" class="text-decoration-none" style="color: gold;">Agendar Cita</a>
    </nav>

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
            <!-- Contenido principal -->
            <div class="container py-5">
                <div class="bg-white rounded shadow mx-auto" style="max-width: 600px;">
                    
                    <!-- Encabezado del formulario -->
                    <div class="w-100 py-3 px-4" style="background-color: #1c1c1c; color: white; border-bottom: 2px solid goldenrod;">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-key-fill me-2" style="color: goldenrod; font-size: 1.5rem;"></i>
                            <h4 class="mb-0 fw-bold">Recuperar Contraseña</h4>
                        </div>
                    </div>

                    <!-- Cuerpo del formulario -->
                    <div class="px-4 py-5">
                        <form id="formNuevaContrasena" class="form-actualizar">
                            <input type="hidden" name="correo" value="<?php echo htmlspecialchars($correo); ?>">
                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">

                            <div class="mb-4">
                                <label for="nueva_contrasena" class="form-label fw-semibold">Nueva Contraseña:</label>
                                <div class="input-group">
                                    <input type="password" name="nueva_contrasena" id="nueva_contrasena" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()" title="Mostrar/Ocultar contraseña">👁</button>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-lg w-100" style="background-color: goldenrod; color: white; border: none;">
                                    Actualizar Contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="text-center py-4 mt-5" style="background-color: #111; color: gold;">
                &copy; 2025 Peluquería Elegante - Todos los derechos reservados
            </footer>

            <!-- SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                function togglePassword() {
                    const input = document.getElementById("nueva_contrasena");
                    input.type = input.type === "password" ? "text" : "password";
                }

                document.getElementById('formNuevaContrasena').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    fetch('../controllers/actualizar_contrasena.php', {
                        method: 'POST',
                        body: new FormData(this)
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data.includes("actualizada exitosamente")) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Contraseña Actualizada!',
                                text: 'Tu contraseña ha sido actualizada exitosamente.',
                                confirmButtonColor: '#daa520'
                            }).then(() => {
                                window.location.href = './usuario/index.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data || 'Hubo un error al actualizar la contraseña.',
                                confirmButtonColor: '#daa520'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al procesar tu solicitud.',
                            confirmButtonColor: '#daa520'
                        });
                    });
                });
            </script>
            <?php
        } else {
            ?>
            <div class="container py-5">
                <div class="alert alert-danger text-center">
                    El enlace de recuperación ha expirado o es inválido.
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="container py-5">
            <div class="alert alert-danger text-center">
                Faltan los parámetros necesarios.
            </div>
        </div>
        <?php
    }
    ?>
</body>
</html>