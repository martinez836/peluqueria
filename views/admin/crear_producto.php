<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crear Producto - Peluquería Elegante</title>
<link rel="stylesheet" href="../../assets/css/crear_producto.css">
</head>
<body>
<header>
    <h1>Peluquería Elegante</h1>
    <p>Panel de Administración - Crear Producto</p>
</header>

<main class="form-container">
    <form action="../../controllers/crear_producto.php" method="POST" enctype="multipart/form-data">
    <h2>Nuevo Producto</h2>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" required min="0" step="100">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen" accept=".jpg, .jpeg, .png" required>

    <button type="submit">Crear Producto</button>
    </form>
</main>
</body>
</html>
