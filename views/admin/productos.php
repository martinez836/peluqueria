<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Productos</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head> 
<body>
<header>Estilos Dairo - Gestión de Productos</header>
<nav>
    <a href="../admin/dashboard.php">Inicio</a>
    <a href="../admin/citas.php">Citas</a>
    <a href="../admin/pedidos.php">Pedidos</a>
    <a href="../../logout.php">Salir</a>
</nav>

<section>
    <h2>Lista de Productos</h2>
    <a href="../admin/crear_producto.php">
        <button class="btn btn-agregar">Agregar Producto</button>
    </a>
    <div class="card">
        <h3>Shampoo Revitalizante</h3>
        <p>Para todo tipo de cabello</p>
        <p>Precio: $15.000</p>
        <a href="./editar_producto.php">
            <button class="btn btn-editar">Editar</button>
        </a>
        <button class="btn btn-eliminar">Eliminar</button>
    </div>
    <!-- Más productos -->
</section>
</body>
</html>
