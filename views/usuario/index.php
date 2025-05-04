<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Peluquería Elegante</title>
<meta name="viewport" content="width=device-width, initial-scale=1"> 


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../../assets/css/estilo.css">
</head>

<body class="fondo">


<header class="text-center py-4" style="background-color: #111; color: gold;">
    <h1>Estilos Dairo</h1>
    <p>¡Reserva tu cita con estilo!</p>
</header>


<nav class="d-flex justify-content-center gap-4 py-3" style="background-color: #222;">
        <?php if(isset($_SESSION['documento'])) {?>
            <a href="./index.php" style="color: gold; text-decoration: none;">Inicio</a>
            <a href="./productos.php" style="color: gold; text-decoration: none;">Productos</a>
            <a href="./agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
            <a href="../../controllers/logOut.php">Cerrar Sesion</a>
        <?php }else{?>
            <a href="./index.php" style="color: gold; text-decoration: none;">Inicio</a>
            <a href="./productos.php" style="color: gold; text-decoration: none;">Productos</a>
            <a href="./agendarCita.php" style="color: gold; text-decoration: none;">Agendar Cita</a>
        <?php }?>   
</nav>


<main class="container my-5">
    <section class="text-center">
    <h2 class="mb-4">Bienvenido a Estilos Dairo</h2>
    <p class="mb-4">
        En <strong>Estilos Dairo</strong> transformamos tu imagen con estilo y elegancia. Nuestro equipo de profesionales te ofrece cortes modernos, coloración, barbería y tratamientos capilares personalizados. ¡Relájate y déjate consentir!
    </p>

    <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
        <img src="../../assets/images/corteHombre.jpeg" alt="Corte masculino moderno" class="img-fluid rounded shadow">
        <p class="mt-2">Barbería y cortes clásicos o urbanos.</p>
        </div>
        <div class="col-md-4 mb-3">
        <img src="../../assets/images/corteDama.jpeg" alt="Corte para dama elegante" class="img-fluid rounded shadow">
        <p class="mt-2">Estilismo femenino con las últimas tendencias.</p>
        </div>
        <div class="col-md-4 mb-3">
        <img src="../../assets/images/tratamientoCapilar.jpeg" alt="Tratamiento capilar" class="img-fluid rounded shadow">
        <p class="mt-2">Tratamientos capilares para brillo y salud.</p>
        </div>
    </div>
</section>

</main>


<footer>
    &copy; 2025 Peluquería Elegante - Todos los derechos reservados
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
