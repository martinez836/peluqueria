<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>
<link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body class="admin-bg">
<div class="admin-form-container">
    <h2>Editar Producto</h2>
    <form action="procesarEdicionProducto.php" method="post" class="admin-form">
    <input type="hidden" name="id_producto" value="1"> <!-- Lo colocas dinámicamente con PHP -->

    <label for="nombre">Nombre del Producto:</label>
    <input type="text" name="nombre" value="Shampoo Revitalizante" required>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" rows="3" required>Ideal para cabello seco</textarea>

    <label for="precio">Precio:</label>
    <input type="number" name="precio" value="15000" required>

    <button type="submit" class="btn-guardar">Guardar Cambios</button>
    <a href="productos.php" class="btn-cancelar">Cancelar</a>
    </form>
</div>
</body>
</html>
