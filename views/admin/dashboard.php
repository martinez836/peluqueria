<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Estilos Dairo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
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
<main class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-light">Dashboard</h2>
            <div>
                <span class="text-light me-2"><i class="far fa-calendar-alt me-1"></i> Hoy: <?php echo date('d/m/Y'); ?></span>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-calendar-check"></i>
                <h3>24</h3>
                <p>Citas Pendientes</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-shopping-cart"></i>
                <h3>12</h3>
                <p>Nuevos Pedidos</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3>156</h3>
                <p>Clientes Activos</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-dollar-sign"></i>
                <h3>$2.5M</h3>
                <p>Ventas Mensuales</p>
            </div>
        </div>
        
        <div class="row">
            <!-- Actividad Reciente -->
            <div class="col-lg-8">
                <div class="dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i class="fas fa-history me-2"></i> Actividad Reciente</h5>
                        <div>
                            <button class="btn btn-sm btn-gold"><i class="fas fa-sync-alt me-1"></i> Actualizar</button>
                        </div>
                    </div>
                    <div class="recent-table">
                        <div class="table-responsive">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Actividad</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>María López</td>
                                        <td>Cita - Corte y Color</td>
                                        <td>10/05/2025</td>
                                        <td><span class="badge bg-warning">Pendiente</span></td>
                                    </tr>
                                    <tr>
                                        <td>Juan Pérez</td>
                                        <td>Pedido #1082</td>
                                        <td>09/05/2025</td>
                                        <td><span class="badge bg-success">Entregado</span></td>
                                    </tr>
                                    <tr>
                                        <td>Carlos Sánchez</td>
                                        <td>Cita - Barbería</td>
                                        <td>09/05/2025</td>
                                        <td><span class="badge bg-success">Completada</span></td>
                                    </tr>
                                    <tr>
                                        <td>Laura Gómez</td>
                                        <td>Pedido #1081</td>
                                        <td>08/05/2025</td>
                                        <td><span class="badge bg-danger">Cancelado</span></td>
                                    </tr>
                                    <tr>
                                        <td>Sofía Martínez</td>
                                        <td>Cita - Manicure</td>
                                        <td>08/05/2025</td>
                                        <td><span class="badge bg-success">Completada</span></td>
                                    </tr>
                                </tbody>
                            </table>
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
                        <div class="list-group-item bg-transparent border-bottom border-secondary text-light p-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-gold">Ana Herrera</h6>
                                <small>10:00 AM</small>
                            </div>
                            <p class="mb-1">Corte de cabello</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Tel: 123-456-7890</small>
                                <span class="badge bg-warning">Pendiente</span>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent border-bottom border-secondary text-light p-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-gold">Luis Mendoza</h6>
                                <small>11:30 AM</small>
                            </div>
                            <p class="mb-1">Barba y bigote</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Tel: 123-456-7890</small>
                                <span class="badge bg-warning">Pendiente</span>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent border-bottom border-secondary text-light p-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-gold">Carmen Diaz</h6>
                                <small>2:00 PM</small>
                            </div>
                            <p class="mb-1">Coloración</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Tel: 123-456-7890</small>
                                <span class="badge bg-warning">Pendiente</span>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent text-light p-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-gold">Roberto Paz</h6>
                                <small>4:30 PM</small>
                            </div>
                            <p class="mb-1">Corte y afeitado</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Tel: 123-456-7890</small>
                                <span class="badge bg-warning">Pendiente</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top border-secondary p-3">
                        <a href="./citas.php" class="btn btn-gold w-100">
                            <i class="fas fa-calendar me-1"></i> Ver todas las citas
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stock Bajo y Últimos Productos -->
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-exclamation-triangle me-2"></i> Productos con Stock Bajo</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Stock Actual</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Shampoo Hidratante</td>
                                    <td>Cabello</td>
                                    <td><span class="text-danger">2 uds</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-gold">Reponer</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Aceite para Barba</td>
                                    <td>Cuidado Facial</td>
                                    <td><span class="text-danger">3 uds</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-gold">Reponer</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tinte Color #5</td>
                                    <td>Coloración</td>
                                    <td><span class="text-danger">1 ud</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-gold">Reponer</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-bell me-2"></i> Recordatorios</h5>
                    </div>
                    <div class="list-group list-group-flush bg-transparent">
                        <div class="list-group-item bg-transparent border-bottom border-secondary text-light p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-truck text-warning fa-2x"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-gold">Pedido de productos</h6>
                                    <p class="mb-0">Confirmar llegada del pedido #A245 para mañana</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent border-bottom border-secondary text-light p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-money-bill-wave text-success fa-2x"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-gold">Pago de servicios</h6>
                                    <p class="mb-0">Recordatorio de pago servicios básicos - vence 15/05</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent text-light p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-user-friends text-info fa-2x"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-gold">Reunión de equipo</h6>
                                    <p class="mb-0">Programada para el 12/05 a las 9:00 AM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/dashboard.js"></script>
</body>
</html>