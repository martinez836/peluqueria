<?php
    session_start();
    require_once '../../models/consultas.php';
    $consultas = new consultas();
    $totalPedidos = $consultas->traerConteoPedido();
    $pedidosPendientes = $consultas->traerPedidoPendiente();
    $pedidosEntregados = $consultas->traerPedidoEntregado();

    $pedidos = $consultas->traerPedidos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pedidos</title>
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/pedidos.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        :root {
            --gold-color: #f1c40f;
            --dark-bg: #1e1e1e;
            --darker-bg: #121212;
        }

        body {
            background-color: var(--dark-bg);
            color: #f8f8f8;
        }

        .pedidos-container {
            padding: 20px;
        }

        .table-section {
            background-color: #2c2c2c;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            border-left: 4px solid var(--gold-color);
            margin-bottom: 20px;
        }

        .detalles-section {
            background-color: #2c2c2c;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            border-left: 4px solid var(--gold-color);
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table thead th {
            background-color: #242424;
            color: var(--gold-color);
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 1px solid rgba(241, 196, 15, 0.2);
        }

        .table td {
            padding: 12px 15px;
            border-top: 1px solid #3a3a3a;
            color: #f8f8f8;
            vertical-align: middle;
        }

        .table tbody tr {
            background-color: #2c2c2c;
        }

        .table tbody tr:hover {
            background-color: #333;
        }

        .table tbody tr:nth-child(even) {
            background-color: #262626;
        }

        .detalles-section .table {
            background-color: #2c2c2c;
            border-radius: 8px;
            overflow: hidden;
        }

        .detalles-section .table th:first-child,
        .detalles-section .table td:first-child {
            padding-left: 20px;
        }

        .detalles-section .table th:last-child,
        .detalles-section .table td:last-child {
            padding-right: 20px;
        }

        .badge-pending {
            background-color: #3498db;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-confirmado {
            background-color: #3498db;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-entregado {
            background-color: #2ecc71;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-cancelado {
            background-color: #e74c3c;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #3498db;
            color: #fff;
        }

        .btn-success {
            background-color: #2ecc71;
            color: #fff;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: #fff;
        }

        .btn-gold {
            background-color: var(--gold-color);
            color: #000;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .pedido-detalles {
            color: #f8f8f8;
        }

        .pedido-detalles h2 {
            color: var(--gold-color);
            border-bottom: 1px solid rgba(241, 196, 15, 0.2);
            padding-bottom: 10px;
            margin-bottom: 20px;
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
    <nav id="sidebar" class="bg-dark">
    <div class="user-info">
        <img src="/api/placeholder/150/150" alt="Admin">
        <h5>Administrador</h5>
        <p>Administrador Principal</p>
    </div>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a class="nav-link " href="./dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
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
            <h1>Gestión de Pedidos</h1>
            <div>
                <button class="btn btn-gold" onclick="exportarPedidos()">
                    <i class="fas fa-download"></i> Exportar
                </button>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="number"><?php echo $totalPedidos; ?></div>
                <div class="label">Pedidos Totales</div>
            </div>
            <div class="stat-card">
                <div class="number"><?php echo $pedidosPendientes; ?></div>
                <div class="label">Pendientes</div>
            </div>
            <div class="stat-card">
                <div class="number"><?php echo $pedidosEntregados; ?></div>
                <div class="label">Entregados</div>
            </div>
            <div class="stat-card">
                <div class="number">$984K</div>
                <div class="label">Ingresos</div>
            </div>
        </div>
        
        <div class="pedidos-container">
            <!-- Tabla de Pedidos -->
            <div class="table-section">
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
                            <?php while($pedido = mysqli_fetch_assoc($pedidos)): ?>
                            <tr class="active">
                                <td><?= $pedido["idpedidos"] ?></td>
                                <td><?= $pedido["nombres"] ?></td>
                                <td><?= $pedido["apellidos"] ?></td>
                                <td><?= $pedido["fecha"] ?></td>
                                <td>$<?= $pedido["total"] ?></td>
                                <td><span class="badge badge-pending"><?= $pedido["estado"] ?></span></td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm verDetallePedido" data-id="<?= $pedido["idpedidos"] ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
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
            
            <!-- Detalles del Pedido -->
            <div class="detalles-section">
                <div class="pedido-detalles" id="detallesPedido">
                    <!-- Los detalles del pedido se cargarán dinámicamente aquí -->
                </div>
                <div class="acciones-estado" style="margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                    <button class="btn btn-primary" onclick="cambiarEstado(this)" data-estado="confirmado">
                        <i class="fas fa-check"></i> Confirmar
                    </button>
                    <button class="btn btn-success" onclick="cambiarEstado(this)" data-estado="entregado">
                        <i class="fas fa-truck"></i> Entregado
                    </button>
                    <button class="btn btn-danger" onclick="cambiarEstado(this)" data-estado="cancelado">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/pedidos.js"></script>
    <script src="../../assets/js/detallePedido.js"></script>
</body>
</html>