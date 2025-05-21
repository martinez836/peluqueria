<?php
session_start();
require_once '../models/consultas.php';
$consultas = new consultas();

if(isset($_POST['idpedido'])) {
    $idpedido = intval($_POST['idpedido']);
    $resultado = $consultas->traerDetallePedido($idpedido);
    
    $detalles = array();
    while($row = mysqli_fetch_assoc($resultado)) {
        $detalles[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'detalles' => $detalles
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'ID de pedido no proporcionado'
    ]);
} 