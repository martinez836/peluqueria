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
    <title>Agendar Cita - Peluquería Elegante</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilo personalizado -->
     
    <link rel="stylesheet" href="../../assets/css/estilo.css">
</head>

<body class="fondo" style="background-color: #f8f8f8;">

    <!-- Header -->
    <header class="text-center py-4" style="background-color: #111; color: gold;">
        <h1>Estilos Dairo</h1>
        <p>¡Reserva tu cita con estilo!</p>
        <?php if(isset($_SESSION['documento'])) { ?>
            <h4>Bienvenido: <?php echo $_SESSION['nombres']; ?></h4>
        <?php } ?>
    </header>

    <!-- Navbar -->
    <nav class="d-flex justify-content-center gap-4 py-3" style="background-color: #222;">
        <a href="./index.php" style="color: gold; text-decoration: none;">Inicio</a>
        <a href="./productos.php" style="color: gold; text-decoration: none;">Productos</a>
        <a href="./agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
        <?php if(isset($_SESSION['documento'])) { ?>
            <a href="../../controllers/logOut.php" style="color: gold; text-decoration: none;">Cerrar Sesión</a>
        <?php } ?>
    </nav>

    <!-- Contenido principal -->
    <div class="container my-5">
        <div class="row align-items-start g-4">
            <!-- Calendario -->
            <div class="col-md-6 d-flex flex-column">
                <div class="bg-white p-4 rounded shadow w-100 h-100">
                    <h2 id="mes-titulo" class="text-center mb-3" style="color: goldenrod;"></h2>
                    <p class="text-center">Selecciona el Día</p>
                    <div class="calendar" id="calendar"></div>
                </div>
            </div>

            <!-- Formulario o inicio de sesión -->
            <div class="col-md-6 d-flex flex-column">
    <div class="bg-white p-0 rounded shadow w-100 h-100 overflow-hidden">
        <?php if(isset($_SESSION['documento'])){ ?>
            <!-- Encabezado del formulario de agendar cita -->
            <div class="w-100 py-3 px-4" style="background-color: #1c1c1c; color: white; border-bottom: 2px solid goldenrod;">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar-check me-2" style="color: goldenrod; font-size: 1.5rem;"></i>
                    <h4 class="mb-0 fw-bold">Agendar Cita</h4>
                </div>
            </div>

            <!-- Cuerpo del formulario -->
            <div class="px-4 py-5">
                <p class="text-center">Fecha Elegida: <span id="fecha-seleccionada" class="fw-bold text-dark"></span></p>

                <form action="../../controllers/crear_cita.php" method="POST" class="agenda-form mt-4">
                    <input type="hidden" name="fecha" id="input-fecha">
                    <input type="hidden" name="cedula" class="form-control" value="<?php echo $_SESSION['documento'] ?>" required>

                    <div class="mb-4">
                        <label for="servicio" class="form-label fw-semibold">Servicio:</label>
                        <select name="servicio" class="form-select" required>
                            <?php while ($row = mysqli_fetch_assoc($servicios)) { ?>
                                <option value="<?php echo $row['idservicios']; ?>"><?php echo $row['nombreServicio']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-lg w-100" style="background-color: goldenrod; color: white; border: none;">
                            Confirmar Cita
                        </button>
                    </div>
                </form>
            </div>
        <?php } else { ?>
    <!-- Contenedor estilo tarjeta -->
    <div class="bg-white p-0 rounded shadow w-100 overflow-hidden">
        
        <!-- Encabezado del formulario -->
        <div class="w-100 py-3 px-4 text-center" style="background-color: #1c1c1c; color: white; border-bottom: 2px solid goldenrod;">
            <h4 class="fw-bold mb-0">Iniciar Sesión</h4>
        </div>

        <!-- Cuerpo del formulario -->
        <div class="px-4 py-5">
            <p class="text-center mb-4">Accede a tu cuenta para agendar una cita</p>
            <?php if (isset($_SESSION['mensaje_error'])): ?>
                <div class="alert alert-danger text-center fw-semibold">
                    <?= $_SESSION['mensaje_error']; ?>
                </div>
                <?php unset($_SESSION['mensaje_error']); ?>
            <?php endif; ?>
            <form action="../../controllers/iniciar_sesion.php" method="POST" class="agenda-form">
                <input type="hidden" name="desdeAgendar" value="1">

                <div class="mb-4">
                    <label for="documento" class="form-label fw-semibold">Documento de identidad</label>
                    <input type="number" name="documento" id="documento" class="form-control" placeholder="Ingresa tu número de documento" required>
                </div>

                <div class="mb-4">
                    <label for="contrasena" class="form-label fw-semibold">Contraseña</label>
                    <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Ingresa tu contraseña" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="recordarme">
                        <label class="form-check-label" for="recordarme">Recordarme</label>
                    </div>
                    <a href="../recuperar.php" style="color: goldenrod; text-decoration: none;">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn btn-lg w-100" style="background-color: goldenrod; color: white; border: none;">
                    Iniciar Sesión
                </button>
            </form>

            <div class="text-center mt-4">
                <p>¿No tienes una cuenta?
                    <a href="./registroSesion.php" style="color: goldenrod; text-decoration: none; font-weight: bold;">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </div>
<?php } ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-light mt-5 border-top">
        &copy; 2025 Peluquería Elegante - Todos los derechos reservados
    </footer>

    <!-- Scripts -->
    <script src="../../assets/js/agendar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
