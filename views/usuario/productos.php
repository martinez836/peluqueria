<?php 
  session_start();
  require_once '../../models/consultas.php'; 
  $consultas = new consultas(); 
  $resultado = $consultas->traerProducto(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos - Peluquería Elegante</title>
  
  <!-- Bootstrap CSS para estructura responsiva -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- Tu estilo personalizado -->
  <link rel="stylesheet" href="../../assets/css/productos.css">
  
  <style>
    /* Estilos adicionales para el carrito */
    .carrito-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: goldenrod;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 24px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      z-index: 1000;
      border: none;
      cursor: pointer;
      transition: transform 0.2s;
    }
    
    .carrito-btn:hover {
      transform: scale(1.1);
    }
    
    .badge-carrito {
      position: absolute;
      top: -5px;
      right: -5px;
      background-color: red;
      color: white;
      border-radius: 50%;
      width: 25px;
      height: 25px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 14px;
      font-weight: bold;
    }
    
    /* Estilos para toast de notificación */
    .toast {
      background-color: white;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .toast-header {
      background-color: #1c1c1c;
      color: goldenrod;
    }
  </style>
</head>
<body class="fondo">

<!-- Header -->
<header class="text-center py-4" style="background-color: #111; color: gold;">
  <h1>Estilos Dairo</h1>
  <p>¡Pide tu producto!</p>
</header>

<!-- Navbar personalizada con estilo propio -->
<nav class="d-flex justify-content-center gap-4 py-3" style="background-color: #222;">
  <?php if(isset($_SESSION['documento'])) {?>
      <a href="./index.php" style="color: gold; text-decoration: none;">Inicio</a>
      <a href="./productos.php" style="color: gold; text-decoration: none;">Productos</a>
      <a href="./agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
      <a href="../../controllers/logOut.php">Cerrar Sesion</a>
      <h4>Bienvenido: <?php echo $_SESSION['nombres']; ?></h4>
  <?php }else{?>
      <a href="./index.php" style="color: gold; text-decoration: none;">Inicio</a>
      <a href="./productos.php" style="color: gold; text-decoration: none;">Productos</a>
      <a href="./agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
  <?php }?>
</nav>

<!-- Contenedor principal -->
<section class="container my-5 productos-section text-center">
  <h2 style="color: goldenrod;" class="mb-4">Nuestros Productos</h2>
  <div class="row justify-content-center g-4">
    <?php while ($producto = $resultado->fetch_assoc()) { ?>
      <div class="col-12 col-sm-6 col-md-4">
        <div class="producto p-3 shadow rounded-3" data-id="<?php echo $producto['id']; ?>">
          <img src="../../<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="img-fluid mb-3" style="max-height: 200px; object-fit: contain;">
          <h3 class="fw-bold"><?php echo $producto['nombre']; ?></h3>
          <p><?php echo $producto['descripcion']; ?></p>
          <span class="precio fw-bold" style="color: goldenrod;">$<?php echo $producto['precio']; ?></span>
          <div class="mt-3 d-flex justify-content-center align-items-center gap-2">
            <input type="number" placeholder="Cantidad" min="1" value="1" class="form-control form-control-sm w-50">
            <button class="btn btn-secondary btn-sm btn-agregar">Agregar</button>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

<!-- Botón flotante para mostrar el carrito -->
<button class="carrito-btn" data-bs-toggle="modal" data-bs-target="#carritoModal">
  <i class="bi bi-cart-fill"></i>
  <span class="badge-carrito" id="carrito-badge" style="display: none;">0</span>
</button>

<!-- Modal del carrito -->
<div class="modal fade" id="carritoModal" tabindex="-1" aria-labelledby="carritoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1c1c1c; color: goldenrod;">
        <h5 class="modal-title" id="carritoModalLabel">Tu Carrito</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Aquí se cargará dinámicamente el contenido del carrito -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Seguir Comprando</button>
        <button type="button" class="btn btn-danger" onclick="vaciarCarrito()">Vaciar Carrito</button>
        <button type="button" class="btn btn-primary" id="btn-finalizar-compra" onclick="finalizarCompra()" disabled>Finalizar Compra</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/carrito.js"></script>

</body>
</html>