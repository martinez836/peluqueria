<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Citas</title>
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/citas.css">
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
            <div class="admin-badge">Admin</div>
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
                <button class="btn btn-gold" onclick="nuevaCita()">
                    <i class="fas fa-plus"></i> Nueva Cita
                </button>
                <button class="btn btn-gold" onclick="exportarCitas()">
                    <i class="fas fa-download"></i> Exportar
                </button>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-row stats-citas">
            <div class="stat-card">
                <div class="number">32</div>
                <div class="label">Citas Totales</div>
            </div>
            <div class="stat-card">
                <div class="number">15</div>
                <div class="label">Pendientes</div>
            </div>
            <div class="stat-card">
                <div class="number">12</div>
                <div class="label">Confirmadas</div>
            </div>
            <div class="stat-card">
                <div class="number">5</div>
                <div class="label">Canceladas</div>
            </div>
        </div>
        
        <!-- Filtros y búsqueda -->
        <div class="search-bar">
            <input type="text" id="buscarCita" placeholder="Buscar por nombre de cliente..." oninput="buscarCitas()">
            <select id="filtroEstado" onchange="filtrarCitas()">
                <option value="todas">Todas las citas</option>
                <option value="pendiente">Pendientes</option>
                <option value="confirmada">Confirmadas</option>
                <option value="cancelada">Canceladas</option>
            </select>
            <button class="btn btn-gold" onclick="buscarCitas()">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
        
        <!-- Contenedor principal de citas -->
        <div class="citas-container">
            <!-- Calendario -->
            <div class="calendario">
                <div class="mes">
                    <button onclick="mesAnterior()"><i class="fas fa-chevron-left"></i></button>
                    <span>Mayo 2025</span>
                    <button onclick="mesSiguiente()"><i class="fas fa-chevron-right"></i></button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Dom</th>
                            <th>Lun</th>
                            <th>Mar</th>
                            <th>Mié</th>
                            <th>Jue</th>
                            <th>Vie</th>
                            <th>Sáb</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td class="has-citas selected">13</td>
                            <td class="has-citas">14</td>
                            <td class="has-citas">15</td>
                            <td>16</td>
                            <td class="has-citas">17</td>
                            <td>18</td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td>20</td>
                            <td class="has-citas">21</td>
                            <td>22</td>
                            <td class="has-citas">23</td>
                            <td>24</td>
                            <td>25</td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td>27</td>
                            <td>28</td>
                            <td>29</td>
                            <td>30</td>
                            <td>31</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Lista de citas -->
            <div class="citas-list">
                <h3>Citas para el 13 de Mayo, 2025</h3>
                
                <div class="cita-card" onclick="verDetalleCita(1001)">
                    <div class="cita-details">
                        <h3>Ana Martínez</h3>
                        <p class="hora"><i class="far fa-clock"></i> 9:00 AM - 10:00 AM</p>
                        <p><i class="fas fa-cut"></i> Corte de Cabello + Peinado</p>
                        <p><i class="fas fa-phone"></i> 300-456-7890</p>
                        <span class="btn-confirmada">Confirmada</span>
                    </div>
                    <div class="cita-actions">
                        <button class="btn btn-primary btn-sm" onclick="verDetalleCita(1001, event)">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="cancelarCita(1001, event)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="cita-card" onclick="verDetalleCita(1002)">
                    <div class="cita-details">
                        <h3>Carlos Ruiz</h3>
                        <p class="hora"><i class="far fa-clock"></i> 11:30 AM - 12:30 PM</p>
                        <p><i class="fas fa-cut"></i> Corte de Cabello</p>
                        <p><i class="fas fa-phone"></i> 301-234-5678</p>
                        <span class="btn-pendiente">Pendiente</span>
                    </div>
                    <div class="cita-actions">
                        <button class="btn btn-primary btn-sm" onclick="verDetalleCita(1002, event)">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="cancelarCita(1002, event)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="cita-card" onclick="verDetalleCita(1003)">
                    <div class="cita-details">
                        <h3>Laura González</h3>
                        <p class="hora"><i class="far fa-clock"></i> 2:00 PM - 4:00 PM</p>
                        <p><i class="fas fa-cut"></i> Tinte + Peinado</p>
                        <p><i class="fas fa-phone"></i> 302-345-6789</p>
                        <span class="btn-confirmada">Confirmada</span>
                    </div>
                    <div class="cita-actions">
                        <button class="btn btn-primary btn-sm" onclick="verDetalleCita(1003, event)">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="cancelarCita(1003, event)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="cita-card" onclick="verDetalleCita(1004)">
                    <div class="cita-details">
                        <h3>Juan Pérez</h3>
                        <p class="hora"><i class="far fa-clock"></i> 5:00 PM - 6:00 PM</p>
                        <p><i class="fas fa-cut"></i> Corte de Barba</p>
                        <p><i class="fas fa-phone"></i> 303-456-7890</p>
                        <span class="btn-cancelada">Cancelada</span>
                    </div>
                    <div class="cita-actions">
                        <button class="btn btn-primary btn-sm" onclick="verDetalleCita(1004, event)">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-success btn-sm" onclick="reactivarCita(1004, event)">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Detalle de la cita seleccionada -->
        <div class="cita-detalle">
            <h2>Detalles de la Cita #1001</h2>
            <div class="cita-info">
                <div>
                    <p><strong>Cliente:</strong> Ana Martínez</p>
                    <p><strong>Teléfono:</strong> 300-456-7890</p>
                    <p><strong>Email:</strong> ana.martinez@email.com</p>
                </div>
                <div>
                    <p><strong>Fecha:</strong> 13/05/2025</p>
                    <p><strong>Hora:</strong> 9:00 AM - 10:00 AM</p>
                    <p><strong>Estado:</strong> <span class="btn-confirmada">Confirmada</span></p>
                </div>
            </div>
            <div>
                <p><strong>Servicio:</strong> Corte de Cabello + Peinado</p>
                <p><strong>Estilista:</strong> Dairo Gómez</p>
                <p><strong>Notas:</strong> Cliente regular. Prefiere corte en capas y secado con volumen.</p>
            </div>
            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button class="btn btn-success" onclick="confirmarCita(1001)">
                    <i class="fas fa-check"></i> Confirmar
                </button>
                <button class="btn btn-primary" onclick="editarCita(1001)">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button class="btn btn-danger" onclick="cancelarCita(1001)">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
    
    <!-- Modal para nueva cita -->
    <div id="nuevaCitaModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2>Agendar Nueva Cita</h2>
            <form id="formNuevaCita">
                <div class="form-group">
                    <label for="nombreCliente">Nombre del Cliente</label>
                    <input type="text" id="nombreCliente" required>
                </div>
                <div class="form-group">
                    <label for="telefonoCliente">Teléfono</label>
                    <input type="tel" id="telefonoCliente" required>
                </div>
                <div class="form-group">
                    <label for="emailCliente">Email</label>
                    <input type="email" id="emailCliente">
                </div>
                <div class="form-group">
                    <label for="fechaCita">Fecha</label>
                    <input type="date" id="fechaCita" required>
                </div>
                <div class="form-group">
                    <label for="horaCita">Hora</label>
                    <input type="time" id="horaCita" required>
                </div>
                <div class="form-group">
                    <label for="servicioCita">Servicio</label>
                    <select id="servicioCita" required>
                        <option value="">Seleccione un servicio</option>
                        <option value="corte">Corte de Cabello</option>
                        <option value="peinado">Peinado</option>
                        <option value="tinte">Tinte</option>
                        <option value="mechas">Mechas</option>
                        <option value="barba">Corte de Barba</option>
                        <option value="tratamiento">Tratamiento Capilar</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="estilista">Estilista</label>
                    <select id="estilista" required>
                        <option value="">Seleccione un estilista</option>
                        <option value="dairo">Dairo Gómez</option>
                        <option value="laura">Laura Sánchez</option>
                        <option value="carlos">Carlos Mendoza</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="notasCita">Notas</label>
                    <input type="text" id="notasCita">
                </div>
                <button type="submit" class="btn btn-gold">Guardar Cita</button>
            </form>
        </div>
    </div>
<script src="../../assets/js/citas.js"></script>
</body>
</html>