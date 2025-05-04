<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Administración - Estilos Dairo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../assets/css/admin.css">
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
        <li class="nav-item"><a class="nav-link text-light" href="./citas.php">Citas</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="./pedidos.php">Pedidos</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="./productos.php">Productos</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="../usuario/index.php">Salir</a></li>
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
        <div class="border-bottom pb-2 mb-2" data-id="1">
            <strong>Juan Pérez</strong><br>
            <small>Tel: 123-456-7890 - Corte de Cabello</small><br>
            <small>Fecha: 2024-03-20</small>
            <div class="mt-2">
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarCitaModal">Editar</button>
            <button class="btn btn-sm btn-danger">Eliminar</button>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- Gestión de Pedidos -->
    <div class="col-md-6">
    <div class="card bg-secondary text-light">
        <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Ultimo Pedido</h5>
        </div>
        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
        <div class="border-bottom pb-2 mb-2" data-id="1">
            <strong>Juan Pérez</strong><br>
            <small>Tel: 123-456-7890 - Corte de Cabello</small><br>
            <small>Fecha: 2024-03-20</small>
            <div class="mt-2">
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarCitaModal">Editar</button>
            <button class="btn btn-sm btn-danger">Eliminar</button>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- Gestión de Productos -->
    <div class="col-6">
    <div class="card bg-secondary text-light">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Gestión de Productos</h5>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#crearProductoModal">Agregar Producto</button>
        </div>
        <div class="card-body">
        <div class="row align-items-center border-bottom pb-2 mb-2" data-id="1" data-stock="10">
            <div class="col-md-2">
            <img src="../../assets/images/producto1.jpg" class="img-fluid rounded" alt="Producto">
            </div>
            <div class="col-md-6">
            <strong>Shampoo</strong><br>
            <small>$25000</small><br>
            <small>Shampoo para cabello seco</small>
            </div>
            <div class="col-md-4 text-end">
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarProductoModal">Editar</button>
            <button class="btn btn-danger btn-sm">Eliminar</button>
            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- Gestión de Servicios -->
    <div class="col-6">
    <div class="card bg-secondary text-light">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Gestión de Servicios</h5>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#crearServicioModal">Agregar Servicio</button>
        </div>
        <div class="card-body">
        <div class="row align-items-center border-bottom pb-2 mb-2" data-id="1">
            <div class="col-md-2">
            <img src="../../assets/images/servicio1.jpg" class="img-fluid rounded" alt="Servicio">
            </div>
            <div class="col-md-6">
            <strong>Corte de Cabello</strong><br>
            <small>$30000</small><br>
            <small>Corte y peinado profesional</small>
            </div>
            <div class="col-md-4 text-end">
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarServicioModal">Editar</button>
            <button class="btn btn-danger btn-sm">Eliminar</button>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
</div>

<!-- Modal Crear Producto -->
<div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-warning">
                <h5 class="modal-title" id="crearProductoModalLabel">Crear Nuevo Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../controllers/crear_producto.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control bg-secondary text-light" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control bg-secondary text-light" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" class="form-control bg-secondary text-light" id="precio" name="precio" required min="0" step="100">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock:</label>
                        <input type="number" class="form-control bg-secondary text-light" id="stock" name="stock" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" class="form-control bg-secondary text-light" id="imagen" name="imagen" accept=".jpg, .jpeg, .png" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Crear Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-warning">
                <h5 class="modal-title" id="editarProductoModalLabel">Editar Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form >
                    <input type="hidden" name="id_producto" id="edit_id_producto">
                    <div class="mb-3">
                        <label for="edit_nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control bg-secondary text-light" id="edit_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control bg-secondary text-light" id="edit_descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_precio" class="form-label">Precio:</label>
                        <input type="number" class="form-control bg-secondary text-light" id="edit_precio" name="precio" required min="0" step="100">
                    </div>
                    <div class="mb-3">
                        <label for="edit_stock" class="form-label">Stock:</label>
                        <input type="number" class="form-control bg-secondary text-light" id="edit_stock" name="stock" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="edit_imagen" class="form-label">Imagen:</label>
                        <input type="file" class="form-control bg-secondary text-light" id="edit_imagen" name="imagen" accept=".jpg, .jpeg, .png">
                        <small class="text-muted">Deja vacío para mantener la imagen actual</small>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Servicio -->
<div class="modal fade" id="crearServicioModal" tabindex="-1" aria-labelledby="crearServicioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-warning">
                <h5 class="modal-title" id="crearServicioModalLabel">Crear Nuevo Servicio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../controllers/crear_servicio.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre_servicio" class="form-label">Nombre:</label>
                        <input type="text" class="form-control bg-secondary text-light" id="nombre_servicio" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion_servicio" class="form-label">Descripción:</label>
                        <textarea class="form-control bg-secondary text-light" id="descripcion_servicio" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Crear Servicio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Servicio -->
<div class="modal fade" id="editarServicioModal" tabindex="-1" aria-labelledby="editarServicioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-warning">
                <h5 class="modal-title" id="editarServicioModalLabel">Editar Servicio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id_servicio" id="edit_id_servicio">
                    <div class="mb-3">
                        <label for="edit_nombre_servicio" class="form-label">Nombre:</label>
                        <input type="text" class="form-control bg-secondary text-light" id="edit_nombre_servicio" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descripcion_servicio" class="form-label">Descripción:</label>
                        <textarea class="form-control bg-secondary text-light" id="edit_descripcion_servicio" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_precio_servicio" class="form-label">Precio:</label>
                        <input type="number" class="form-control bg-secondary text-light" id="edit_precio_servicio" name="precio" required min="0" step="100">
                    </div>
                    <div class="mb-3">
                        <label for="edit_imagen_servicio" class="form-label">Imagen:</label>
                        <input type="file" class="form-control bg-secondary text-light" id="edit_imagen_servicio" name="imagen" accept=".jpg, .jpeg, .png">
                        <small class="text-muted">Deja vacío para mantener la imagen actual</small>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Cita -->
<div class="modal fade" id="editarCitaModal" tabindex="-1" aria-labelledby="editarCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-warning">
                <h5 class="modal-title" id="editarCitaModalLabel">Editar Cita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id_cita" id="edit_id_cita">
                    <div class="mb-3">
                        <label for="edit_nombre_cliente" class="form-label">Nombre del Cliente:</label>
                        <input type="text" class="form-control bg-secondary text-light" id="edit_nombre_cliente" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_telefono" class="form-label">Teléfono:</label>
                        <input type="tel" class="form-control bg-secondary text-light" id="edit_telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_servicio" class="form-label">Servicio:</label>
                        <input type="text" class="form-control bg-secondary text-light" id="edit_servicio" name="servicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_fecha" class="form-label">Fecha:</label>
                        <input type="date" class="form-control bg-secondary text-light" id="edit_fecha" name="fecha" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/dashboard.js"></script>
</body>
</html>
