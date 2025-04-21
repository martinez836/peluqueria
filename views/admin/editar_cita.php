<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Cita</title>
<link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body class="admin-bg">
<div class="admin-form-container">
    <h2>Editar Cita</h2>
    <form action="procesarEdicionCita.php" method="post" class="admin-form">
    <input type="hidden" name="id_cita" value="3"> <!-- ID dinámico -->

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="Juan Pérez" required>

    <label for="telefono">Teléfono:</label>
    <input type="tel" name="telefono" value="3001234567" required>

    <label for="servicio">Servicio:</label>
    <input type="text" name="servicio" value="Corte de cabello" required>

    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" value="2025-04-25" required>

    <button type="submit" class="btn-guardar">Guardar Cambios</button>
    <a href="citas.php" class="btn-cancelar">Cancelar</a>
    </form>
</div>
</body>
</html>
