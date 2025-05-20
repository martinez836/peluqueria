<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de Envio de correo</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu estilo personalizado -->
    <link rel="stylesheet" href="../../assets/css/estilo.css">
</head>

<body class="fondo" style="background-color: #f8f8f8;">

    <!-- Header -->
    <header class="text-center py-4" style="background-color: #111; color: gold;">
        <h1>Estilos Dairo</h1>
        <p>¡Recuperación de Contraseñas!</p>
    </header>

    <!-- Navbar -->
    <nav class="d-flex justify-content-center gap-4 py-3" style="background-color: #222;">
        <a href="../views/usuario/index.php" style="color: gold; text-decoration: none;">Inicio</a>
        <a href="../views/usuario/productos.php" style="color: gold; text-decoration: none;">Productos</a>
        <a href="../views/usuario/agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
    </nav>

    <!-- Contenido principal -->
<div class="container py-5">
    <div class="bg-white rounded shadow mx-auto" style="max-width: 600px;">
        
        <!-- Encabezado del formulario -->
        <div class="w-100 py-3 px-4" style="background-color: #1c1c1c; color: white; border-bottom: 2px solid goldenrod;">
            <div class="d-flex align-items-center justify-content-center">
                <i class="bi bi-envelope-fill me-2" style="color: goldenrod; font-size: 1.5rem;"></i>
                <h4 class="mb-0 fw-bold">Recuperar Contraseña</h4>
            </div>
        </div>

        <!-- Cuerpo del formulario -->
        <div class="px-4 py-5">
            <div class="text-center mb-4">
                <h5 style="color: #333;">¿Olvidaste tu contraseña?</h5>
                <p class="text-muted">Ingresa tu correo electrónico y te enviaremos las instrucciones para recuperarla.</p>
            </div>

            <form action="../controllers/recuperar_contrasena.php" method="POST" class="form-recuperar">
                <div class="mb-4">
                    <label for="correo" class="form-label fw-semibold">Correo Electrónico:</label>
                    <input type="email" name="correo" id="correo" class="form-control" placeholder="Introduce tu correo electrónico" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-lg w-100" style="background-color: goldenrod; color: white; border: none;">
                        Recuperar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>




