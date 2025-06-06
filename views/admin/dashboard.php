<?php
require_once '../../middleware/auth.php';

// Verificar que el usuario esté autenticado y sea administrador
verificarSesion('administrador');

// Incluir el archivo de autenticación
require_once 'auth_admin.php';

require_once '../../models/consultas.php';
$consultas = new consultas();
$citasPendientes = $consultas->traerCitaPendiente();
$pedidosPendientes = $consultas->traerPedidoPendiente();
$clientes = $consultas->traerConteoCliente();
$fechasDeshabilitadas = $consultas->traerFechasDeshabilitadas();
$productosStockBajo = $consultas->traerProductosStockBajo();
$citasHoy = $consultas->traerCitasHoy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Estilos Dairo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="stylesheet" href="../../assets/css/calendario.css">

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
            <a href="../../controllers/logOut.php" style="color: gold; text-decoration: none;">Cerrar Sesión</a>
        </div>
    </header>

<!-- Sidebar -->
<nav id="sidebar" >
    <div class="user-info">

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
<main class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-light">dashboard</h2>
            <div>
                <span class="text-light me-2"><i class="far fa-calendar-alt me-1"></i> Hoy: <?php echo date('d/m/Y'); ?></span>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-calendar-check" style="color: #FFD700;"></i>
                <h3><?php echo $citasPendientes; ?></h3>
                <p>Citas Pendientes</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-shopping-cart" style="color: #FFD700;"></i>
                <h3><?php echo $pedidosPendientes; ?></h3>
                <p>Nuevos Pedidos</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-users" style="color: #FFD700;"></i>
                <h3><?php echo $clientes; ?></h3>
                <p>Clientes Existentes</p>
            </div>
        </div>
        
        <div class="row">
            <!-- Actividad Reciente -->
<!-- Calendario con navegación mejorada -->
<div class="col-lg-8">
    <div class="dashboard-card bg-dark text-light">
        <p class="text-light mb-1 text-center">CALENDARIO</p>

        <!-- Encabezado del calendario con título y navegación -->
        <div class="calendar-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
            <button id="mes-anterior" class="btn btn-sm btn-outline-light">
                <i class="fas fa-chevron-left"></i>
            </button>
            <h5 id="mes-titulo" class="mb-0 text-center flex-grow-1"> <!-- Título dinámico aquí --> </h5>
            <button id="mes-siguiente" class="btn btn-sm btn-outline-light">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <!-- Cuerpo del calendario -->
        <div id="calendar" class="calendar-grid"></div>

        <!-- Formulario para habilitar y deshabilitar fechas del calendario-->
        <form id="form-fechas" method="POST" action="../../controllers/guardarFechas.php" class="mt-3">
            <input type="hidden" id="fechas-deshabilitadas" name="fechas_deshabilitadas">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <button type="submit" name="accion" value="deshabilitar" class="btn btn-danger w-100">
                        <i class="fas fa-ban me-1"></i> Deshabilitar Fechas Seleccionadas
                    </button>
                </div>
                <div class="col-md-6 mb-2">
                    <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalFechas">
                        <i class="fas fa-check-circle me-1"></i> Habilitar Fechas Seleccionadas
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
     


<!-- Modal de Fechas Deshabilitadas -->
<div class="modal fade" id="modalFechas" tabindex="-1" aria-labelledby="modalFechasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFechasLabel">Fechas Deshabilitadas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul id="listaFechasDeshabilitadas" class="list-group">
                    <!-- Las fechas deshabilitadas se cargarán aquí -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button id="habilitarFechas" class="btn btn-success">Habilitar Seleccionadas</button>
            </div>
        </div>
    </div>
</div>       
            <!-- Citas de Hoy -->
            <div class="col-lg-4">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-calendar-day me-2"></i> Citas de Hoy</h5>
                    </div>
                    <div class="list-group list-group-flush bg-transparent">
                        <?php 
                        if(mysqli_num_rows($citasHoy) > 0) {
                            while($cita = mysqli_fetch_assoc($citasHoy)) {
                        ?>
                            <div class="list-group-item bg-transparent border-bottom border-secondary text-light p-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 text-gold"><?php echo htmlspecialchars($cita['nombres'] . ' ' . $cita['apellidos']); ?></h6>
                                </div>
                                <p class="mb-1"><?php echo htmlspecialchars($cita['nombreServicio']); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Tel: <?php echo htmlspecialchars($cita['telefono']); ?></small>
                                    <span class="badge bg-warning"><?php echo htmlspecialchars($cita['estado']); ?></span>
                                </div>
                            </div>
                        <?php 
                            }
                        } else {
                        ?>
                            <div class="list-group-item bg-transparent text-light p-3 text-center">
                                <p class="mb-0">No hay citas programadas para hoy</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="card-footer bg-transparent border-top border-secondary p-3">
                        <a href="./citas.php" class="btn btn-gold w-100">
                            <i class="fas fa-calendar me-1"></i> Ver todas las citas
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stock Bajo y Recordatorios -->
        <div class="row mt-4">
            <!-- Productos con Stock Bajo -->
            <div class="col-lg-6">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-exclamation-triangle me-2 text-warning"></i> 
                            Productos con Stock Bajo
                        </h5>
                    </div>
                    <div class="list-group list-group-flush bg-transparent">
                        <?php while($producto = mysqli_fetch_assoc($productosStockBajo)): ?>
                        <div class="list-group-item bg-transparent border-bottom border-secondary text-light p-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-gold"><?= $producto['nombre'] ?></h6>
                                <small class="text-danger">Stock: <?= $producto['stock'] ?></small>
                            </div>
                            <p class="mb-1">Precio: $<?= number_format($producto['precio'], 2) ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">ID: <?= $producto['id'] ?></small>
                                <?php if($producto['stock'] <= 5): ?>
                                    <span class="badge bg-danger">Crítico</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Bajo</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            
            <!-- Separador invisible para mejor espaciado -->
            <div class="col-lg-1"></div>
        </div>
    </div>
</main>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/pedidos.js"></script>

<!-- Asegurar que las fechas deshabilitadas estén disponibles -->
<script>
    // Esta línea asegura que las fechas deshabilitadas estén disponibles para los scripts
    window.fechasDeshabilitadas = <?php echo json_encode($fechasDeshabilitadas); ?>;
    console.log('Fechas deshabilitadas iniciales:', window.fechasDeshabilitadas);
</script>

<!-- Scripts del calendario -->
<script src="../../assets/js/calendarioAdmin.js"></script>
<script src="../../assets/js/habilitarFechas.js"></script>

</body>
</html>