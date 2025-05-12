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
        <p>¡Crea tu cuenta y reserva con estilo!</p>
    </header>

    <!-- Navbar -->
    <nav class="d-flex justify-content-center gap-4 py-3" style="background-color: #222;">
        <a href="./index.php" style="color: gold; text-decoration: none;">Inicio</a>
        <a href="./productos.php" style="color: gold; text-decoration: none;">Productos</a>
        <a href="./agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
    </nav>

    <!-- Contenido principal -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-center mb-4" style="color: goldenrod;">Recuperar Contraseña</h2>
                    <form action="../controllers/recuperar_contrasena.php" method="POST" class="form-recuperar">
                        <div class="mb-3">
                            <input type="email" name="correo" class="form-control" placeholder="Introduce tu correo electrónico" required>
                        </div>
                        <div class="text-center mb-3">
                            <button type="submit" class="btn btn-dark px-4" style="background-color: goldenrod; border: none;">Recuperar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>




