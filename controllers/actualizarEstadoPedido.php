<?php
header('Content-Type: application/json');
require_once '../models/consultas.php';

if(isset($_POST['idpedido']) && isset($_POST['estado'])) {
    $idpedido = $_POST['idpedido'];
    $estado = $_POST['estado'];
    
    $consultas = new consultas();
    $resultado = $consultas->actualizarEstadoPedido($idpedido, $estado);
    
    if($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Estado del pedido actualizado correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar el estado del pedido'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos requeridos'
    ]);
} 