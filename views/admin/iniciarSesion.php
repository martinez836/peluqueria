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
    <div class="container my-5">
        <div class="row justify-content-center">
            
            <div class="col-6">
                <!-- Formulario Inicio de Sesión Administrador -->
                <div class="bg-white p-4 rounded shadow mx-auto" style="max-width: 600px;">
                    <h2 class="text-center mb-4" style="color: goldenrod;">Inicio de Sesión Administradores</h2>
                    <form  action="../../controllers/iniciar_sesion.php" method="POST" class="agenda-form mt-4">
                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento:</label>
                            <input type="number" name="documento" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contrasena:</label>
                            <input type="password" name="contrasena" class="form-control" required>
                        </div>
                        <br><a href="../recuperar.php" class="recuperar-link" style="color: goldenrod;">¿Olvidaste tu contraseña?</a><br><br><!-- Enlace para recuperar contraseña -->
                        <div class="text-center mb-3">
                            <button type="submit" class="btn btn-dark px-4" style="background-color: goldenrod; border: none;">Ingresar</button>
                        </div>
                    </form>                    
                </div>
                <!-- Fin del formulario de inicio de sesión -->
            </div>
        </div>
    </div>

    <script src="../../assets/js/agendar.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


