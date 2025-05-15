<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Estilos Dairo</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
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

    <!-- Contenido principal -->
    <div class="container py-5">
        <div class="bg-white rounded shadow mx-auto" style="max-width: 1000px;">
            
            <!-- Encabezado del formulario -->
            <div class="w-100 py-3 px-4" style="background-color: #1c1c1c; color: white; border-bottom: 2px solid goldenrod;">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="bi bi-scissors me-2" style="color: goldenrod; font-size: 1.5rem;"></i>
                    <h4 class="mb-0 fw-bold">Crea tu Cuenta</h4>
                </div>
            </div>

            <!-- Cuerpo del formulario -->
            <div class="px-4 py-5">
                <?php if (isset($_SESSION['mensaje_error'])): ?>
                    <div class="alert alert-danger text-center fw-semibold">
                        <?= $_SESSION['mensaje_error']; ?>
                    </div>
                    <?php unset($_SESSION['mensaje_error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['mensaje_exito'])): ?>
                    <div class="alert alert-success text-center fw-semibold">
                        <?= $_SESSION['mensaje_exito']; ?>
                    </div>
                    <?php unset($_SESSION['mensaje_exito']); ?>
                <?php endif; ?>
                <!-- Mensaje de bienvenida -->
                <div class="text-center mb-4">
                    <h5 style="color: #333;">Bienvenido a Estilos Dairo</h5>
                    <p class="text-muted">Crea tu cuenta para disfrutar de nuestros servicios</p>
                </div>

                <form method="POST" action="../../controllers/registro.php" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <label for="documento" class="form-label fw-semibold">Documento:</label>
                            <input type="number" name="documento" id="documento" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <label for="nombres" class="form-label fw-semibold">Nombres:</label>
                            <input type="text" name="nombres" id="nombres" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <label for="apellidos" class="form-label fw-semibold">Apellidos:</label>
                            <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <label for="ciudad" class="form-label fw-semibold">Ciudad:</label>
                            <input type="text" name="ciudad" id="ciudad" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <label for="direccion" class="form-label fw-semibold">Dirección:</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <label for="barrio" class="form-label fw-semibold">Barrio:</label>
                            <input type="text" name="barrio" id="barrio" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <label for="telefono" class="form-label fw-semibold">Teléfono:</label>
                            <input type="tel" name="telefono" id="telefono" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <label for="correo" class="form-label fw-semibold">Correo Electrónico:</label>
                            <input type="email" name="correo" id="correo" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <label for="fechaNacimiento" class="form-label fw-semibold">Fecha de Nacimiento:</label>
                            <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="contrasena" class="form-label fw-semibold">Contraseña:</label>
                            <div class="input-group">
                                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()" title="Mostrar/Ocultar contraseña">👁</button>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de envío -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-lg w-100" style="background-color: goldenrod; color: white; border: none;">
                            Registrarse
                        </button>
                    </div>
                </form>

                <!-- Separador -->
                <div class="d-flex align-items-center my-4">
                    <div class="flex-grow-1 border-bottom"></div>
                    <span class="mx-2 text-muted">O</span>
                    <div class="flex-grow-1 border-bottom"></div>
                </div>

                <!-- Enlace a login -->
                <div class="text-center">
                    <p class="mb-0">¿Ya tienes cuenta?
                        <a href="./agendarCita.php" class="fw-bold" style="color: goldenrod; text-decoration: none;">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y script de contraseña -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/contrasena.js"></script>
</body>
</html>
