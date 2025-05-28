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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/pedidos.css">
    <link rel="stylesheet" href="../../assets/css/tablas.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                                <?php while($pedido = mysqli_fetch_assoc($pedidos)): ?>
                                <tr>
                                    <td class="text-white"><?= $pedido["idpedidos"] ?></td>
                                    <td class="text-white"><?= $pedido["nombres"] ?></td>
                                    <td class="text-white"><?= $pedido["apellidos"] ?></td>
                                    <td class="text-white"><?= $pedido["fecha"] ?></td>
                                    <td class="text-white">$<?= number_format($pedido["total"], 2) ?></td>
                                    <td><span class="badge badge-pending text-white"><?= $pedido["estado"] ?></span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm verDetallePedido" data-id="<?= $pedido["idpedidos"] ?>">
                                            <i class="fas fa-eye"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/pedidos.js"></script>
    <script src="../../assets/js/detallePedido.js"></script>

    <script>
    function cambiarEstado(btn) {
        const estado = btn.dataset.estado;
        const idPedido = btn.closest('.acciones-estado').dataset.pedidoId;
        let titulo, texto, icono;

        switch(estado) {
            case 'confirmado':
                titulo = '¿Confirmar este pedido?';
                texto = '¿Estás seguro de que deseas confirmar este pedido?';
                icono = 'question';
                break;
            case 'entregado':
                titulo = '¿Marcar como entregado?';
                texto = '¿Estás seguro de que deseas marcar este pedido como entregado?';
                icono = 'question';
                break;
            case 'cancelado':
                titulo = '¿Cancelar este pedido?';
                texto = '¿Estás seguro de que deseas cancelar este pedido?';
                icono = 'warning';
                break;
        }

        Swal.fire({
            title: titulo,
            text: texto,
            icon: icono,
            showCancelButton: true,
            confirmButtonColor: estado === 'cancelado' ? '#d33' : '#28a745',
            cancelButtonColor: estado === 'cancelado' ? '#3085d6' : '#d33',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../../controllers/actualizarEstadoPedido.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `idpedido=${idPedido}&estado=${estado}`
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        let mensajeExito;
                        switch(estado) {
                            case 'confirmado':
                                mensajeExito = 'El pedido ha sido confirmado';
                                break;
                            case 'entregado':
                                mensajeExito = 'El pedido ha sido marcado como entregado';
                                break;
                            case 'cancelado':
                                mensajeExito = 'El pedido ha sido cancelado';
                                break;
                        }

                        Swal.fire({
                            title: '¡Completado!',
                            text: mensajeExito,
                            icon: 'success',
                            confirmButtonColor: '#daa520'
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                });
            }
        });
    }
    </script>
</body>
</html>