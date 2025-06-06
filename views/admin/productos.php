<?php
require_once '../../middleware/auth.php';

// Verificar que el usuario esté autenticado y sea administrador
verificarSesion('administrador');

require_once '../../models/consultas.php';
$consultas = new consultas();
$productos = $consultas->traerProducto();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/crear_producto.css">
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
            <a href="../../controllers/logOut.php" style="color: gold; text-decoration: none;">Cerrar Sesión</a>
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
            <h1>Gestión de Productos</h1>
        </div>
        
        <div class="productos-container">
            <!-- Formulario de Productos -->
            <div class="form-section">
                <div class="producto-form">
                    <div class="form-header">
                        <h2><i class="fas fa-plus-circle"></i> Crear Producto</h2>
                    </div>
                    <form id="formCrearProducto" action="../../controllers/crear_producto.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nombre">Nombre del Producto</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" 
                                   id="precio" 
                                   name="precio" 
                                   class="form-control" 
                                   step="0.01" 
                                   min="1" 
                                   oninput="validarNumeroPositivo(this)"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" 
                                   id="stock" 
                                   name="stock" 
                                   class="form-control" 
                                   min="1" 
                                   oninput="validarNumeroPositivo(this)"
                                   required>
                        </div>                         
                        <div class="form-group">
                            <label for="imagen">Imagen del Producto</label>
                            <input type="file" id="imagen" name="imagen" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-gold">
                                <i class="fas fa-save"></i> Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Tabla de Productos -->
            <div class="table-section">
                <div class="pedidos-table">
                    <div class="table-responsive">
                        <table id="tabla-pedidos" class="table responsive nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($producto = mysqli_fetch_assoc($productos)): ?>
                                <tr class="active">
                                    <td><?= $producto["id"] ?></td>
                                    <td><?= $producto["nombre"] ?></td>
                                    <td>$<?= $producto["precio"] ?></td>
                                    <td><?= $producto["stock"] ?></td>
                                    <td class="actions">
                                        <button type="button" class="btn btn-success btn-sm">
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
            </div>
        </div>
    </div>

    <!-- Modal para editar producto -->
    <div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header border-bottom border-secondary">
                    <h5 class="modal-title text-gold" id="editarProductoModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarProductoForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" id="editNombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control bg-dark text-light border-secondary" id="editDescripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editPrecio" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark text-light border-secondary">$</span>
                                <input type="number" 
                                       class="form-control bg-dark text-light border-secondary" 
                                       id="editPrecio" 
                                       name="precio" 
                                       step="0.01" 
                                       min="1"
                                       oninput="validarNumeroPositivo(this)"
                                       required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editStock" class="form-label">Stock</label>
                            <input type="number" 
                                   class="form-control bg-dark text-light border-secondary" 
                                   id="editStock" 
                                   name="stock" 
                                   min="1"
                                   oninput="validarNumeroPositivo(this)"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label for="editImagen" class="form-label">Nueva Imagen (opcional)</label>
                            <input type="file" class="form-control bg-dark text-light border-secondary" id="editImagen" name="imagen" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-warning" id="guardarCambios">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../assets/js/productos.js"></script>

<script>
    // Función para validar números positivos
    function validarNumeroPositivo(input) {
        if (input.value <= 0) {
            input.value = 1;
        }
    }

    // Validar el formulario antes de enviar
    document.querySelector('form').addEventListener('submit', function(e) {
        const precio = document.getElementById('precio');
        const stock = document.getElementById('stock');
        
        if (precio.value <= 0 || stock.value <= 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El precio y el stock deben ser mayores a 0',
                confirmButtonColor: '#daa520'
            });
        }
    });

    // Manejar el envío del formulario de crear producto
    $('#formCrearProducto').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                        confirmButtonColor: '#daa520'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonColor: '#daa520'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al procesar la solicitud',
                    confirmButtonColor: '#daa520'
                });
            }
        });
    });
</script>
</html>