<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Administración - Estilos Dairo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../assets/css/admin.css"> <!-- Personaliza aquí tu estilo -->
</head>
<body class="bg-dark text-light">

<!-- HEADER -->
<header class="py-4 bg-black text-center text-warning">
<h1>Panel de Administración</h1>
<p class="text-light">Bienvenido, Admin</p>
</header>

<!-- NAV -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-warning">
<div class="container-fluid">
    <a class="navbar-brand text-warning" href="#">Estilos Dairo</a>
    <div class="collapse navbar-collapse">
    <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link text-light" href="../admin/citas.php">Citas</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="../admin/pedidos.php">Pedidos</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="../admin/productos.php">Productos</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="#">Salir</a></li>
    </ul>
    </div>
</div>
</nav>

<!-- CONTENIDO PRINCIPAL -->
<div class="container py-4">
<div class="row g-4">
    <!-- Citas -->
    <div class="col-md-6">
    <div class="card bg-secondary text-light">
        <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Citas Pendientes</h5>
        </div>
        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
        <!-- Repetir por cada cita -->
        <div class="border-bottom pb-2 mb-2">
            <strong>Juan Pérez</strong><br>
            <small>Tel: 3001234567 - Corte de cabello</small><br>
            <small>Fecha: 2025-04-25</small>
            <div class="mt-2">
            <button class="btn btn-sm btn-warning">Editar</button>
            <button class="btn btn-sm btn-danger">Eliminar</button>
            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- Pedidos -->
    <div class="col-md-6">
    <div class="card bg-secondary text-light">
        <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Pedidos Recibidos</h5>
        </div>
        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
        <!-- Repetir por cada pedido -->
        <div class="border-bottom pb-2 mb-2">
            <strong>Maria Gómez</strong><br>
            <small>Shampoo x2, Mascarilla x1</small><br>
            <small>Total: $39000</small>
            <div class="mt-2">
            <button class="btn btn-sm btn-danger">Eliminar</button>
            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- Gestión de Productos -->
    <div class="col-12">
    <div class="card bg-secondary text-light">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Gestión de Productos</h5>
        <a href="crearProducto.php" class="btn btn-success btn-sm">Agregar Producto</a>
        </div>
        <div class="card-body">
        <!-- Repetir por cada producto -->
        <div class="row align-items-center border-bottom pb-2 mb-2">
            <div class="col-md-2">
            <img src="../../assets/imgs/shampoo.png" class="img-fluid rounded" alt="Producto">
            </div>
            <div class="col-md-6">
            <strong>Shampoo Revitalizante</strong><br>
            <small>$15000</small><br>
            <small>Para todo tipo de cabello</small>
            </div>
            <div class="col-md-4 text-end">
            <a href="editarProducto.php?id=1" class="btn btn-warning btn-sm">Editar</a>
            <button class="btn btn-danger btn-sm">Eliminar</button>
            </div>
        </div>
        </div>
    </div>
    </div>

</div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
