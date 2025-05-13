<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pedidos</title>
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/pedidos.css">
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
            <a class="nav-link " href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
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
                <div class="number">24</div>
                <div class="label">Pedidos Totales</div>
            </div>
            <div class="stat-card">
                <div class="number">8</div>
                <div class="label">Pendientes</div>
            </div>
            <div class="stat-card">
                <div class="number">12</div>
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
                <div class="search-bar">
                    <input type="text" id="buscarPedido" placeholder="Buscar por nombre de cliente..." oninput="buscarPedidos()">
                    <button class="btn btn-gold" onclick="buscarPedidos()">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
                
                <div class="pedidos-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ejemplo de pedidos -->
                                <tr class="active" onclick="verDetalle(12345)">
                                    <td>12345</td>
                                    <td>María Gómez</td>
                                    <td>10/05/2025</td>
                                    <td>$54.000</td>
                                    <td><span class="badge badge-pending">Pendiente</span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="verDetalle(12345)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarPedido(12345, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="verDetalle(12346)">
                                    <td>12346</td>
                                    <td>Juan Pérez</td>
                                    <td>09/05/2025</td>
                                    <td>$78.000</td>
                                    <td><span class="badge badge-processing">Procesando</span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="verDetalle(12346)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarPedido(12346, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="verDetalle(12347)">
                                    <td>12347</td>
                                    <td>Ana Martínez</td>
                                    <td>08/05/2025</td>
                                    <td>$45.000</td>
                                    <td><span class="badge badge-shipped">Enviado</span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="verDetalle(12347)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarPedido(12347, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="verDetalle(12348)">
                                    <td>12348</td>
                                    <td>Carlos Ruiz</td>
                                    <td>07/05/2025</td>
                                    <td>$36.000</td>
                                    <td><span class="badge badge-delivered">Entregado</span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="verDetalle(12348)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarPedido(12348, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="verDetalle(12349)">
                                    <td>12349</td>
                                    <td>Laura González</td>
                                    <td>05/05/2025</td>
                                    <td>$62.000</td>
                                    <td><span class="badge badge-cancelled">Cancelado</span></td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="verDetalle(12349)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarPedido(12349, event)">
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
                        <button class="btn btn-success" onclick="cambiarEstado(12345, 'procesando')">
                            <i class="fas fa-check"></i> Procesar
                        </button>
                        <button class="btn btn-danger" onclick="cancelarPedido(12345)">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para alternar el menú lateral
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });
        
        // Función para mostrar detalles del pedido
        function verDetalle(id) {
            // Aquí se podría hacer una petición AJAX para obtener los detalles del pedido
            // Por ahora solo marcaremos la fila como activa
            
            // Quitar la clase active de todas las filas
            document.querySelectorAll('.table tbody tr').forEach(tr => {
                tr.classList.remove('active');
            });
            
            // Añadir la clase active a la fila seleccionada
            document.querySelector(`.table tbody tr[onclick="verDetalle(${id})"]`).classList.add('active');
            
            // Simulación de carga de detalles
            // En un entorno real, aquí cargarías los detalles desde el servidor
        }
        
        // Función para eliminar un pedido
        function eliminarPedido(id, event) {
            // Detener la propagación del evento para que no se active verDetalle
            if (event) {
                event.stopPropagation();
            }
            
            if (confirm(`¿Estás seguro de que deseas eliminar el pedido #${id}?`)) {
                // Aquí se haría la petición AJAX para eliminar el pedido
                console.log(`Eliminando pedido ${id}`);
                // Simulación de eliminación
                // En un entorno real, aquí eliminarías el pedido en el servidor
            }
        }
        
        // Función para cambiar el estado de un pedido
        function cambiarEstado(id, estado) {
            // Aquí se haría la petición AJAX para cambiar el estado
            console.log(`Cambiando estado del pedido ${id} a ${estado}`);
            // Simulación de cambio de estado
            // En un entorno real, aquí cambiarías el estado en el servidor
        }
        
        // Función para cancelar un pedido
        function cancelarPedido(id) {
            if (confirm(`¿Estás seguro de que deseas cancelar el pedido #${id}?`)) {
                cambiarEstado(id, 'cancelado');
            }
        }
        
        // Función para exportar pedidos
        function exportarPedidos() {
            // Aquí se haría la exportación de los pedidos
            console.log('Exportando pedidos...');
            // En un entorno real, aquí exportarías los pedidos a un archivo
        }
        
        // Función para buscar pedidos
        function buscarPedidos() {
            const filtro = document.getElementById('buscarPedido').value.toLowerCase();
            const filas = document.querySelectorAll('.table tbody tr');
            
            filas.forEach(fila => {
                const nombreCliente = fila.children[1].textContent.toLowerCase();
                if (nombreCliente.includes(filtro)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
        
        // Inicializar - Mostrar el primer pedido
        window.onload = function() {
            verDetalle(12345);
        };
    </script>
</body>
</html>