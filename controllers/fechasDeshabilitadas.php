<?php
header('Content-Type: application/json');

require_once '../models/consultas.php';  // Ajusta esta ruta según tu estructura

$consultas = new consultas();
$fechas = $consultas->traerFechasDeshabilitadas();

echo json_encode($fechas);
?>

