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
                </div>
            </div>
        </div>
    </div>
        <!-- Modal para editar cita -->
        <div class="modal fade" id="editarCitaModal" tabindex="-1" aria-labelledby="editarCitaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header border-bottom border-secondary">
                        <h5 class="modal-title text-gold" id="editarCitaModalLabel">Editar Cita</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editarCitaForm">
                            <input type="hidden" id="editCitaId" name="idcita">
                            <div class="mb-3">
                                <label for="editNombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control bg-dark text-light" id="editNombres" name="nombres" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="editApellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control bg-dark text-light" id="editApellidos" name="apellidos" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="editFecha" class="form-label">Fecha y Hora</label>
                                <input type="datetime-local" class="form-control bg-dark text-light" id="editFecha" name="fecha" required>
                            </div>
                            <div class="mb-3">
                                <label for="editServicio" class="form-label">Servicio</label>
                                <select class="form-select bg-dark text-light" id="editServicio" name="servicio" required>
                                    <?php 
                                    $servicios = $consultas->traer_servicios();
                                    while($servicio = mysqli_fetch_assoc($servicios)): 
                                    ?>
                                        <option value="<?= $servicio['idservicios'] ?>"><?= $servicio['nombreServicio'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editEstado" class="form-label">Estado</label>
                                <select class="form-select bg-dark text-light" id="editEstado" name="estado" required>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="confirmado">Confirmado</option>
                                    <option value="completado">Completado</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-top border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-gold" id="guardarCambiosCita">Guardar cambios</button>
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
    <script src="../../assets/js/editarCita.js"></script>
    <script src="../../assets/js/citas.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para manejar el detalle de la cita
        document.querySelectorAll('.verDetalle').forEach(btn => {
            btn.addEventListener('click', function() {
                const data = this.dataset;
                const detallesCita = document.getElementById('detallesCita');
                
                // HTML para los detalles de la cita
                const html = `
                    <h3 class="text-gold mb-4">Detalles de la Cita</h3>
                    <div class="info-group">
                        <p><strong>Cliente:</strong> ${data.nombre} ${data.apellido}</p>
                        <p><strong>Fecha:</strong> ${data.fecha}</p>
                        <p><strong>Servicio:</strong> ${data.servicio}</p>
                        <p><strong>Estado:</strong> ${data.estado}</p>
                        <p><strong>Email:</strong> ${data.email}</p>
                        <p><strong>Teléfono:</strong> ${data.telefono}</p>
                    </div>
                    <div class="actions-group mt-4">
                        <button class="btn btn-success" onclick="confirmarCita(${data.id})">Confirmar</button>
                        <button class="btn btn-primary" onclick="completarCita(${data.id})">Completar</button>
                        <button class="btn btn-danger" onclick="cancelarCita(${data.id})">Cancelar</button>
                    </div>
                `;
                
                detallesCita.innerHTML = html;
            });
        });

        // Manejador para eliminar citas
        document.querySelectorAll('.eliminarCita').forEach(btn => {
            btn.addEventListener('click', function() {
                const idCita = this.getAttribute('data-id');
                
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('../../controllers/cambiar_estado_cita.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `idcita=${idCita}&estado=inactivo`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire({
                                    title: '¡Eliminada!',
                                    text: 'La cita ha sido eliminada',
                                    icon: 'success',
                                    confirmButtonColor: '#daa520'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'No se pudo eliminar la cita',
                                    icon: 'error',
                                    confirmButtonColor: '#daa520'
                                });
                            }
                        });
                    }
                });
            });
        });
    });

    // Función para confirmar cita
    function confirmarCita(idCita) {
        Swal.fire({
            title: '¿Confirmar esta cita?',
            text: "¿Estás seguro de que deseas confirmar esta cita?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../../controllers/confirmarCita.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'idcita=' + idCita
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            title: '¡Confirmada!',
                            text: 'La cita ha sido confirmada',
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

    // Función para completar cita
    function completarCita(idCita) {
        Swal.fire({
            title: '¿Completar esta cita?',
            text: "¿Estás seguro de que deseas marcar esta cita como completada?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, completar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../../controllers/completarCita.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'idcita=' + idCita
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            title: '¡Completada!',
                            text: 'La cita ha sido completada',
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

    // Función para cancelar cita
    function cancelarCita(idCita) {
        Swal.fire({
            title: '¿Cancelar esta cita?',
            text: "¿Estás seguro de que deseas cancelar esta cita?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, mantener'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../../controllers/cancelarCita.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'idcita=' + idCita
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            title: '¡Cancelada!',
                            text: 'La cita ha sido cancelada',
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