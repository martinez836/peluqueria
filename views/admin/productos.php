<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Productos</title>
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/crear_producto.css">
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
                    <form action="../../controllers/crear_producto.php" method="POST" enctype="multipart/form-data">
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
                            <input type="number" id="precio" name="precio" class="form-control" step="0.01" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" name="stock" class="form-control" required>
                        </div>                         
                        <div class="form-group">
                            <label for="imagen">Imagen del Producto</label>
                            <input type="file" id="imagen" name="imagen" class="form-control">
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
                <div class="productos-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Categoría</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ejemplo de productos -->
                                <tr>
                                    <td>1</td>
                                    <td>Shampoo Alisador</td>
                                    <td>$15.000</td>
                                    <td>25</td>
                                    <td>Shampoo</td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="editarProducto(1)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarProducto(1)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Acondicionador Hidratante</td>
                                    <td>$18.000</td>
                                    <td>15</td>
                                    <td>Acondicionador</td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="editarProducto(2)">
                                            <i class="fas fa-edit">Editar</i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarProducto(2)">
                                            <i class="fas fa-trash">Eliminar</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Mascarilla Reparadora</td>
                                    <td>$24.000</td>
                                    <td>10</td>
                                    <td>Tratamiento</td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="editarProducto(3)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarProducto(3)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Spray Voluminizador</td>
                                    <td>$20.000</td>
                                    <td>8</td>
                                    <td>Styling</td>
                                    <td class="actions">
                                        <button class="btn btn-primary btn-sm" onclick="editarProducto(4)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarProducto(4)">
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
        </div>
    </div>
</body>
</html>