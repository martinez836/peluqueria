<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Citas</title>
    <link rel="stylesheet" href="../../assets/css/citas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
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
    <nav id="sidebar" class="bg-dark">
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
                <a class="nav-link active" href="./citas.php"><i class="fas fa-calendar-check"></i> Citas</a>
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
        <div class="stats-row">
            <div class="stat-card">
                <div class="number">32</div>
                <div class="label">Citas Totales</div>
            </div>
            <div class="stat-card">
                <div class="number">14</div>
                <div class="label">Pendientes</div>
            </div>
            <div class="stat-card">
                <div class="number">18</div>
                <div class="label">Completadas</div>
            </div>
            <div class="stat-card">
                <div class="number">$1.2M</div>
                <div class="label">Ingresos</div>
            </div>
        </div>
        
        <div class="citas-container">
            <!-- Tabla de Citas (Izquierda) -->
            <div class="table-section">
                <!-- Barra de búsqueda -->
                <div class="search-bar">
                    <input type="text" id="buscarCita" placeholder="Buscar por nombre de cliente..." oninput="buscarCitas()">
                    <button class="btn btn-gold" onclick="buscarCitas()">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
                
                <div class="citas-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Servicio</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ejemplo de citas -->
                                <tr class="active" onclick="verDetalle(1001)">
                                    <td>1001</td>
                                    <td>Carmen Díaz</td>
                                    <td>15/05/2025</td>
                                    <td>Corte y Peinado</td>
                                    <td><span class="badge badge-confirmed">Confirmada</span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="editarCita(1001, event)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarCita(1001, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="verDetalle(1002)">
                                    <td>1002</td>
                                    <td>Roberto Fernández</td>
                                    <td>15/05/2025</td>
                                    <td>Corte de Cabello</td>
                                    <td><span class="badge badge-pending">Pendiente</span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="editarCita(1002, event)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarCita(1002, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="verDetalle(1003)">
                                    <td>1003</td>
                                    <td>Patricia García</td>
                                    <td>15/05/2025</td>
                                    <td>Tinte y Peinado</td>
                                    <td><span class="badge badge-confirmed">Confirmada</span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="editarCita(1003, event)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarCita(1003, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="verDetalle(1004)">
                                    <td>1004</td>
                                    <td>Javier Ramírez</td>
                                    <td>16/05/2025</td>
                                    <td>Corte de Barba</td>
                                    <td><span class="badge badge-completed">Completada</span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="editarCita(1004, event)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarCita(1004, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="verDetalle(1005)">
                                    <td>1005</td>
                                    <td>Luisa Martínez</td>
                                    <td>16/05/2025</td>
                                    <td>Tratamiento Capilar</td>
                                    <td><span class="badge badge-cancelled">Cancelada</span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="editarCita(1005, event)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarCita(1005, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- PHP generará más filas dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Detalles de la Cita (Derecha) -->
                <div class="detalles-section">
                    <div class="cita-detalles" id="detallesCita">
                        <h2>Detalles de la Cita #1001</h2>
                        <div class="cliente-info">
                            <p><strong>Cliente:</strong> Carmen Díaz</p>
                            <p><strong>Email:</strong> carmen@gmail.com</p>
                            <p><strong>Teléfono:</strong> 310-456-7890</p>
                            <p><strong>Fecha:</strong> 15/05/2025</p>
                            <p><strong>Hora:</strong> 10:00 AM</p>
                            <p><strong>Estado:</strong> <span class="badge badge-confirmed">Confirmada</span></p>
                        </div>
                        
                        <div class="servicio-info">
                            <h3>Servicios Solicitados</h3>
                            <div class="servicio-item">
                                <div>Corte de Cabello</div>
                            </div>
                            <div class="servicio-item">
                                <div>Peinado</div>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; margin-top: 15px; font-weight: bold;">
                                <div>Total</div>
                            </div>
                        </div>
                        
                        <div class="notas-cita">
                            <h3>Notas</h3>
                            <p>Cliente habitual. Prefiere corte en capas y peinado con ondas suaves.</p>
                        </div>
                        
                        <div class="acciones-cita">
                            <button class="btn btn-success" onclick="cambiarEstado(1001, 'completada')">
                                <i class="fas fa-check"></i> Completar
                            </button>
                            <button class="btn btn-primary" onclick="confirmarCita(1001)">
                                <i class="fas fa-bell"></i> Confirmar
                            </button>
                            <button class="btn btn-danger" onclick="cancelarCita(1001)">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../assets/js/citas.js"></script>
    </body>
</html>