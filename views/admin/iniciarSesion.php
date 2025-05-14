<?php
    session_start();
    require_once '../../models/consultas.php';
    $consultas = new consultas();
    $servicios = $consultas->traer_servicios();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio Sesion Administrador</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu estilo personalizado -->
    <link rel="stylesheet" href="../../assets/css/estilo.css">
</head>

<body class="fondo" style="background-color: #f8f8f8;">

    <!-- Header -->
    <header class="text-center py-4" style="background-color: #111; color: gold;">
        <h1>Estilos Dairo</h1>
        <p>¡Reserva tu cita con estilo!</p>
    </header>

    <!-- Navbar -->
    <nav class="d-flex justify-content-center gap-4 py-3" style="background-color: #222;">
        <?php if(isset($_SESSION['documento'])) {?>
            <a href="./dashboard.php" style="color: gold; text-decoration: none;">Inicio</a>
            <a href="../usuario/productos.php" style="color: gold; text-decoration: none;">Productos</a>
            <a href="../usuario/agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
            <a href="../../controllers/logOut.php">Cerrar Sesion</a>
        <?php }else{?>
            <!-- <a href="../usuario/index.php" style="color: gold; text-decoration: none;">Inicio</a>
            <a href="../usuario/productos.php" style="color: gold; text-decoration: none;">Productos</a>
            <a href="../usuario/agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a> -->
            <a href="../../controllers/logOut.php">Regresar</a>
        <?php }?>
    </nav>
    <!-- Contenido principal -->
    <!-- Contenido principal -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <!-- Formulario de Inicio de Sesión Administrador -->
            <div class="bg-white rounded shadow mx-auto px-0 pb-5 pt-0" style="max-width: 700px; overflow: hidden;">
                <!-- Encabezado dentro del formulario -->
                <div class="py-3 px-4" style="background-color: #1c1c1c; color: white; border-bottom: 2px solid goldenrod;">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-shield-lock me-2" style="color: goldenrod; font-size: 1.5rem;"></i>
                        <h4 class="mb-0 fw-bold">Inicio de Sesión - Administrador</h4>
                    </div>
                </div>

                <!-- Formulario -->
                <div class="px-4 pt-4">
                    <form action="../../controllers/iniciar_sesion.php" method="POST" class="agenda-form">
                        <!-- Documento -->
                        <div class="mb-4">
                            <label for="documento" class="form-label fw-semibold">Documento:</label>
                            <div class="input-group">
                                <input type="number" name="documento" id="documento" class="form-control" required placeholder="Ingresa tu número de documento">
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-4">
                            <label for="contrasena" class="form-label fw-semibold">Contraseña:</label>
                            <div class="input-group">
                                <input type="password" name="contrasena" id="contrasena" class="form-control" required placeholder="Ingresa tu contraseña">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordAdmin()" title="Mostrar/Ocultar contraseña">👁</button>
                            </div>
                        </div>
                        <!-- Recuperar contraseña -->
                        <div class="mb-4 text-end">
                            <a href="../recuperar.php" class="text-decoration-none fw-semibold" style="color: goldenrod;">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>

                        <!-- Botón de ingreso -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg w-100" style="background-color: goldenrod; color: white; border: none;">
                                Ingresar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="../../assets/js/agendar.js"></script>
    <script src="../../assets/js/contrasena.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


