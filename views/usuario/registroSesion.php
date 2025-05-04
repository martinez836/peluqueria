<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro - Estilos Dairo</title>

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
                    <h2 class="text-center mb-4" style="color: goldenrod;">Registrarse</h2>
                    <form method="POST" action="../../controllers/registro.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento:</label>
                            <input type="number" name="documento" id="documento" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombres:</label>
                            <input type="text" name="nombres" id="nombres" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Apellidos:</label>
                            <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="ciudad" class="form-label">Ciudad:</label>
                            <input type="text" name="ciudad" id="ciudad" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="barrio" class="form-label">Barrio:</label>
                            <input type="text" name="barrio" id="barrio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="tel" name="telefono" id="telefono" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Correo Electrónico:</label>
                            <input type="email" name="correo" id="correo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Contraseña:</label>
                            <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                        </div>
                        <div class="text-center mb-3">
                            <button type="submit" class="btn btn-dark px-4" style="background-color: goldenrod; border: none;">Registrarse</button>
                        </div>
                    </form>
                    <p class="text-center mt-3">
                        ¿Ya tienes cuenta? <a href="./login.php" style="color: goldenrod;">Inicia sesión aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
