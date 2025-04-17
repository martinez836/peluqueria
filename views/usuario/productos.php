<?php
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

  <!-- Tu estilo personalizado -->
  <link rel="stylesheet" href="../../assets/css/productos.css">
</head>
<body>

<!-- Header -->
<header class="text-center py-4" style="background-color: #111; color: gold;">
  <h1>Estilos Dairo</h1>
  <p>¡Pide tu producto!</p>
</header>

<!-- Navbar personalizada con estilo propio -->
<nav class="d-flex justify-content-center gap-4 py-3" style="background-color: #222;">
  <a href="servicios.php" style="color: gold; text-decoration: none;">Servicios</a>
  <a href="productos.php" style="color: gold; text-decoration: none;">Productos</a>
  <a href="../usuario/agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
  <a href="contacto.php" style="color: gold; text-decoration: none;">Contacto</a>
</nav>

<!-- Contenedor principal -->
<section class="container my-5 productos-section text-center">
  <h2 style="color: goldenrod;" class="mb-4">Nuestros Productos</h2>
  <div class="row justify-content-center g-4">
    <?php while ($producto = $resultado->fetch_assoc()) { ?>
      <div class="col-12 col-sm-6 col-md-4">
        <div class="producto p-3 shadow rounded-3">
          <img src="../../<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="img-fluid mb-3" style="max-height: 200px; object-fit: contain;">
          <h3 class="fw-bold"><?php echo $producto['nombre']; ?></h3>
          <p><?php echo $producto['descripcion']; ?></p>
          <span style="color: goldenrod;" class="fw-bold">$<?php echo $producto['precio']; ?></span>
          <div class="mt-3 d-flex justify-content-center align-items-center gap-2">
            <input type="number" placeholder="Cantidad" min="0" class="form-control form-control-sm w-50">
            <button class="btn btn-secondary btn-sm">Agregar</button>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
