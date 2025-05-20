<?php
    session_start();
    require_once '../../models/consultas.php';
    $consultas = new consultas();
    $citasPendientes = $consultas->traerCitaPendiente();
    $citaConfirmada = $consultas->traerCitaConfirmada();
    $citaCancelada = $consultas->traerCitaCancelada();
    $citas = $consultas->traerCitas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Citas</title>

    <!-- Font Awesome para iconos -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/citas.css">
    <style>
        
    </style>
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
        <li class="nav-item mt-3">
            <a class="nav-link text-danger" href="../usuario/index.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
        </li>
    </ul>
</nav>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1>Gestión de Citas</h1>
            <div>
                <button class="btn btn-primary" onclick="nuevaCita()">
                    <i class="fas fa-plus"></i> Nueva Cita
                </button>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-calendar-check"></i>
                <h3><?php echo $citasPendientes; ?></h3>
                <p>Citas Pendientes</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-shopping-cart"></i>
                <h3><?php echo $citaConfirmada; ?></h3>
                <p>Citas Confirmadas</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3><?php echo $citaCancelada; ?></h3>
                <p>Citas Canceladas</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-dollar-sign"></i>
                <h3>$2.5M</h3>
                <p>Ventas Mensuales</p>
            </div>
        </div>
        
        <div class="citas-container">
            <!-- Tabla de Citas (Izquierda) -->
            <div class="table-section">
                <!-- Barra de búsqueda -->         
                <div class="citas-table">
                    <div class="pedidos-table">
                    <div class="table-responsive">
                        <table id="tabla-pedidos" class="table responsive nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($cita = mysqli_fetch_assoc($citas)): ?>
                                <tr class="active">
                                    <td><?= $cita["idcitas"] ?></td>
                                    <td><?= $cita["nombres"] ?></td>
                                    <td><?= $cita["apellidos"] ?></td>
                                    <td><?= $cita["fecha"] ?></td>
                                    <td><?= $cita["nombreServicio"] ?></td>
                                    <td><span class="badge badge-pending"><?= $cita["estado"] ?></span></td>
                                    <td class="actions">
                                        <button  class="btn btn-primary btn-sm verDetalle" data-id="<?= $cita['idcitas'] ?>"
                                            data-nombre="<?= $cita['nombres'] ?>"
                                            data-apellido="<?= $cita['apellidos'] ?>"
                                            data-fecha="<?= $cita['fecha'] ?>"
                                            data-servicio="<?= $cita['nombreServicio'] ?>"
                                            data-estado="<?= $cita['estado'] ?>"
                                            data-email="<?= $cita['correo'] ?>"
                                            data-telefono="<?= $cita['telefono'] ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-success btn-sm" id="editarCita">
                                            <i class="fas fa-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" id="eliminarCita">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- PHP generará más filas dinámicamente -->
                                 <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- Detalles de la Cita (Derecha) -->
                <div class="detalles-section">
                    <div class="cita-detalles" id="detallesCita">
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="../../assets/js/detalleCita.js"></script>
        <script src="../../assets/js/citas.js"></script>
    </body>
</html>