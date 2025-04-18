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
        <a href="./index.php" style="color: gold; text-decoration: none;">Inicio</a>
        <a href="./productos.php" style="color: gold; text-decoration: none;">Productos</a>
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
            <div class="formulario-cita bg-white p-4 rounded shadow mx-auto" style="max-width: 600px;">
                    <h2 class="text-center mb-4" style="color: goldenrod;">Agendar Cita</h2>
                    <p class="text-center">Has seleccionado la fecha: <span id="fecha-seleccionada" class="fw-bold text-dark"></span></p>

                    <form action="../usuario/index.php" method="post" class="agenda-form mt-4">
                        <input type="hidden" name="fecha" id="input-fecha">

                        <div class="mb-3">
                            <label for="cedula" class="form-label">Cédula:</label>
                            <input type="number" name="cedula" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" name="apellido" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="tel" name="telefono" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico:</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                            <input type="date" name="fechaNacimiento" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="servicio" class="form-label">Servicio:</label>
                            <select name="servicio" class="form-select" required>
                                <option value="">Seleccione el servicio</option>
                                <option value="">fsds</option>
                                <!-- Puedes agregar más opciones desde PHP si lo necesitas -->
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-dark px-4" style="background-color: goldenrod; border: none;">Confirmar Cita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/agendar.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


