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
            <a href="./index.php" style="color: gold; text-decoration: none;">Inicio</a>
            <a href="./productos.php" style="color: gold; text-decoration: none;">Productos</a>
            <a href="./agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
            <a href="../../controllers/logOut.php">Cerrar Sesion</a>
            <h4>Bienvenido: <?php echo $_SESSION['nombres']; ?></h4>
        <?php }else{?>
            <a href="./index.php" style="color: gold; text-decoration: none;">Inicio</a>
            <a href="./productos.php" style="color: gold; text-decoration: none;">Productos</a>
            <a href="./agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
        <?php }?>
    </nav>

    <!-- Contenido principal -->
    <div class="container my-5">
        <div class="row">
            <div class="col-6">
            <h2 id="mes-titulo" class="text-center my-3"></h2>
                <p class="text-center">Selecciona un día para agendar tu cita:</p>
                <div class="calendar" id="calendar"></div>
            </div>
            <div class="col-6">
            <?php if(isset($_SESSION['documento'])){ ?>
            <div class="formulario-cita bg-white p-4 rounded shadow mx-auto" style="max-width: 600px;">
                    <h2 class="text-center mb-4" style="color: goldenrod;">Agendar Cita</h2>
                    <p class="text-center">Has seleccionado la fecha: <span id="fecha-seleccionada" class="fw-bold text-dark"></span></p>

                    <form action="../../controllers/crear_cita.php" method="POST" class="agenda-form mt-4">
                        <input type="hidden" name="fecha" id="input-fecha">

                        <div class="mb-3">
                            <label for="cedula" class="form-label">Cédula:</label>
                            <input type="number" name="cedula" class="form-control" value="<?php echo $_SESSION['documento'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $_SESSION['nombres']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" name="apellido" class="form-control" value="<?php echo $_SESSION['apellidos']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="tel" name="telefono" class="form-control" value="<?php echo $_SESSION['telefono']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico:</label>
                            <input type="email" name="correo" class="form-control" value="<?php echo $_SESSION['correo']; ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="servicio" class="form-label">Servicio:</label>
                            <select name="servicio" class="form-select" required>
                                <?php
                                    while ($row = mysqli_fetch_assoc($servicios))
                                    {
                                        ?><option value="<?php echo $row['idservicios']; ?>"><?php echo $row['nombre']; ?></option>
                                        <?php   
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-dark px-4" style="background-color: goldenrod; border: none;">Confirmar Cita</button>
                        </div>
                    </form>
                </div>
                <?php }else{ ?>
                <!-- Formulario Inicio de Sesión Refactorizado -->
<div class="bg-white rounded shadow mx-auto" style="max-width: 600px; overflow: hidden; border: none;">
    <!-- Encabezado con estilo similar al modal -->
    <div class="py-3 px-4" style="background-color: #1c1c1c; color: white; border-bottom: 2px solid goldenrod;">
        <div class="d-flex align-items-center justify-content-center">
            <i class="bi bi-scissors me-2" style="color: goldenrod; font-size: 1.5rem;"></i>
            <h4 class="mb-0 fw-bold">Iniciar Sesión</h4>
        </div>
    </div>
    
    <div class="p-4 p-md-5">
        <!-- Mensaje de bienvenida -->
        <div class="text-center mb-4">
            <h5 style="color: #333;">Bienvenido a Estilos Dairo</h5>
            <p class="text-muted">Accede a tu cuenta para disfrutar de nuestros servicios</p>
        </div>
        
        <form action="../../controllers/iniciar_sesion.php" method="POST" class="agenda-form">
            <!-- Campos de formulario con iconos -->
            <div class="mb-4">
                <label for="documento" class="form-label fw-semibold">Documento de identidad</label>
                <div class="input-group">
                    <span class="input-group-text" style="background-color: #f8f8f8;">
                        <i class="bi bi-person" style="color: goldenrod;"></i>
                    </span>
                    <input type="number" name="documento" id="documento" class="form-control form-control-lg border-start-0" 
                           placeholder="Ingresa tu número de documento" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="contrasena" class="form-label fw-semibold">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text" style="background-color: #f8f8f8;">
                        <i class="bi bi-lock" style="color: goldenrod;"></i>
                    </span>
                    <input type="password" name="contrasena" id="contrasena" class="form-control form-control-lg border-start-0" 
                           placeholder="Ingresa tu contraseña" required>
                </div>
            </div>
            
            <!-- Enlaces de ayuda -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="recordarme" style="border-color: goldenrod;">
                    <label class="form-check-label" for="recordarme">Recordarme</label>
                </div>
                <a href="../recuperar.php" style="color: goldenrod; text-decoration: none; font-weight: 500;">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
            
            <!-- Botón de inicio de sesión -->
            <button type="submit" class="btn btn-lg w-100 mb-3" style="background-color: goldenrod; color: white; border: none;">
                Iniciar Sesión
            </button>
        </form>
        
        <!-- Separador -->
        <div class="d-flex align-items-center my-3">
            <div class="flex-grow-1 border-bottom"></div>
            <span class="mx-2 text-muted">O</span>
            <div class="flex-grow-1 border-bottom"></div>
        </div>
        
        <!-- Enlace para registro -->
        <div class="text-center">
            <p class="mb-0">¿No tienes una cuenta? 
                <a href="./registroSesion.php" style="color: goldenrod; text-decoration: none; font-weight: bold;">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </div>
    
    <!-- Footer con branding discreto -->
    <div class="py-3 text-center bg-light" style="border-top: 1px solid #eee;">
        <small class="text-muted">© 2025 Estilos Dairo - Todos los derechos reservados</small>
    </div>
</div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="../../assets/js/agendar.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


