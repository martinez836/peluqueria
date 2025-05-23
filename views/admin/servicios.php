<?php
    session_start();
    require_once '../../models/consultas.php';
    $consultas = new consultas();
    $servicios = $consultas->traer_servicios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Servicios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/crear_producto.css">
    <link rel="stylesheet" href="../../assets/css/tablas.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <button id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="logo">Estilos Dairo</div>
        <div>
            <span>Admin</span>
        </div>
    </header>
    
    <!-- Sidebar -->
    <nav id="sidebar" >
        <div class="user-info">
            <img src="/api/placeholder/150/150" alt="Admin">
            <h5>Administrador</h5>
            <p>Administrador Principal</p>
        </div>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link" href="./dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./citas.php"><i class="fas fa-calendar-check"></i> Citas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./pedidos.php"><i class="fas fa-shopping-cart"></i> Pedidos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./productos.php"><i class="fas fa-box-open"></i> Productos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./servicios.php"><i class="fas fa-cut"></i> Servicios</a>
            </li>
            <li class="nav-item mt-3">
                <a class="nav-link text-danger" href="../usuario/index.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </li>
        </ul>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1>Gestión de Servicios</h1>
        </div>
        
        <div class="productos-container">
            <!-- Formulario de Servicios -->
            <div class="form-section">
                <div class="producto-form">
                    <div class="form-header">
                        <h2><i class="fas fa-plus-circle"></i> Crear Servicio</h2>
                    </div>
                    <form action="../../controllers/crear_servicio.php" method="POST">
                        <div class="form-group">
                            <label for="nombreServicio">Nombre del Servicio</label>
                            <input type="text" id="nombreServicio" name="nombreServicio" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-gold">
                                <i class="fas fa-save"></i> Guardar Servicio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Tabla de Servicios -->
            <div class="table-section">
                <div class="pedidos-table">
                    <div class="table-responsive">
                        <table id="tabla-servicios" class="table responsive nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre del Servicio</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($servicio = mysqli_fetch_assoc($servicios)): ?>
                                <tr>
                                    <td><?= $servicio["idservicios"] ?></td>
                                    <td><?= $servicio["nombreServicio"] ?></td>
                                    <td><?= $servicio["descripcion"] ?></td>
                                    <td class="actions">

                                        <button class="btn btn-success btn-sm">
                                            <i class="fas fa-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar servicio -->
    <div class="modal fade" id="editarServicioModal" tabindex="-1" aria-labelledby="editarServicioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header border-bottom border-secondary">
                    <h5 class="modal-title text-gold" id="editarServicioModalLabel">Editar Servicio</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarServicioForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editNombreServicio" class="form-label">Nombre del Servicio</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" id="editNombreServicio" name="nombreServicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control bg-dark text-light border-secondary" id="editDescripcion" name="descripcion" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-warning" id="guardarCambios">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/servicios.js"></script>
</body>
</html> 