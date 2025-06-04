<?php
    session_start();
    require_once '../../models/consultas.php';
    $consultas = new consultas();
    $citasPendientes = $consultas->traerCitaPendiente();
    $citaConfirmada = $consultas->traerCitaConfirmada();
    $citaCancelada = $consultas->traerCitaCancelada();
    $citaCompletada = $consultas->traerCitaCompetada();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/citas.css">
    <link rel="stylesheet" href="../../assets/css/tablas.css">
    <style>
        .detalles-section {
            background: #1a1a1a;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-left: 20px;
            min-width: 350px;
            max-width: 400px;
        }

        .cita-detalles {
            color: #fff;
        }

        .cita-detalles h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 15px;
            border-bottom: 2px solid #daa520;
        }

        .info-group {
            margin-bottom: 2rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
        }

        .info-item i {
            width: 24px;
            color: #daa520;
            margin-right: 10px;
        }

        .info-item .label {
            font-weight: bold;
            color: #daa520;
            min-width: 120px;
            margin-right: 10px;
        }

        .info-item .value {
            color: #fff;
            flex: 1;
        }

        .servicios-solicitados {
            margin-top: 2rem;
        }

        .servicios-solicitados h4 {
            color: #daa520;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .servicio-item {
            background: rgba(218, 165, 32, 0.1);
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            border-left: 3px solid #daa520;
        }

        .actions-group {
            display: flex;
            gap: 10px;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .actions-group button {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .actions-group button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-completar {
            background-color: #28a745;
            border: none;
            color: white;
        }

        .btn-confirmar {
            background-color: #007bff;
            border: none;
            color: white;
        }

        .btn-cancelar {
            background-color: #dc3545;
            border: none;
            color: white;
        }
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
            <h1>Gestión de Citas</h1>
            
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
                <i class="fas fa-calendar-check"></i>
                <h3><?php echo $citaCompletada; ?></h3>
                <p>Citas Completadas</p>
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
                                    <th class="text-gold">#</th>
                                    <th class="text-gold">Nombres</th>
                                    <th class="text-gold">Apellidos</th>
                                    <th class="text-gold">Fecha</th>
                                    <th class="text-gold">Total</th>
                                    <th class="text-gold">Estado</th>
                                    <th class="text-gold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-white">
                                <?php while($cita = mysqli_fetch_assoc($citas)): ?>
                                <tr>
                                    <td class="text-white"><?= $cita["idcitas"] ?></td>
                                    <td class="text-white"><?= $cita["nombres"] ?></td>
                                    <td class="text-white"><?= $cita["apellidos"] ?></td>
                                    <td class="text-white"><?= $cita["fecha"] ?></td>
                                    <td class="text-white"><?= $cita["nombreServicio"] ?></td>
                                    <td><span class="badge badge-pending text-white"><?= $cita["estado"] ?></span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm verDetalle" data-id="<?= $cita['idcitas'] ?>"
                                            data-nombre="<?= $cita['nombres'] ?>"
                                            data-apellido="<?= $cita['apellidos'] ?>"
                                            data-fecha="<?= $cita['fecha'] ?>"
                                            data-servicio="<?= $cita['nombreServicio'] ?>"
                                            data-estado="<?= $cita['estado'] ?>"
                                            data-email="<?= $cita['correo'] ?>"
                                            data-telefono="<?= $cita['telefono'] ?>"
                                            data-fechaNacimiento="<?= $cita['fechaNacimiento'] ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm eliminarCita" data-id="<?= $cita['idcitas'] ?>">
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
                    <!-- El contenido se llenará dinámicamente con JavaScript -->
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/detalleCita.js"></script>
    <script src="../../assets/js/citas.js"></script>
</body>
</html>