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
            <!-- Tabla de Pedidos (Ahora a la izquierda) -->
            <div class="table-section">
                <!-- Barra de búsqueda simple -->  
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
                                <?php while($pedido = mysqli_fetch_assoc($pedidos)): ?>
                                <tr class="active">
                                    <td><?= $pedido["idpedidos"] ?></td>
                                    <td><?= $pedido["nombres"] ?></td>
                                    <td><?= $pedido["apellidos"] ?></td>
                                    <td><?= $pedido["fecha"] ?></td>
                                    <td>$<?= $pedido["total"] ?></td>
                                    <td><span class="badge badge-pending"><?= $pedido["estado"] ?></span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm">
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
                                <!-- PHP generará más filas dinámicamente -->
                                 <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Detalles del Pedido (Ahora a la derecha) -->
            <div class="detalles-section">
                <div class="pedido-detalles" id="detallesPedido">
                    <h2>Detalles del Pedido #12345</h2>
                    <div class="cliente-info">
                        <p><strong>Cliente:</strong> María Gómez</p>
                        <p><strong>Email:</strong> maria@gmail.com</p>
                        <p><strong>Teléfono:</strong> 300-123-4567</p>
                        <p><strong>Fecha:</strong> 10/05/2025</p>
                        <p><strong>Estado:</strong> <span class="badge badge-pending">Pendiente</span></p>
                        <p><strong>Dirección:</strong> Calle 123 #45-67, Bogotá</p>
                    </div>
                    
                    <h3>Productos</h3>
                    <div class="detalle-item">
                        <div>Shampoo Alisador</div>
                        <div>2 x $15.000</div>
                    </div>
                    <div class="detalle-item">
                        <div>Mascarilla Reparadora</div>
                        <div>1 x $24.000</div>
                    </div>
                    
                    <div class="detalle-total">
                        <div class="label">Total</div>
                        <div>$54.000</div>
                    </div>
                    
                    <div style="margin-top: 20px; display: flex; gap: 10px;">
                        <button class="btn btn-primary" onclick="cambiarEstado(12345, 'procesando')">
                            <i class="fas fa-check"></i> Confirmar
                        </button>
                        <button class="btn btn-danger" onclick="cancelarPedido(12345)">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button class="btn btn-success" onclick="cancelarPedido(12345)">
                            <i class="fas fa-box"></i> Entregado
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/pedidos.js"></script>
</body>
</html>