<?php
require_once '../models/consultas.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idpedido = $_POST['idpedido'] ?? null;
    $estado = $_POST['estado'] ?? null;

    if (!$idpedido || !$estado) {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan datos requeridos'
        ]);
        exit;
    }

    $consultas = new consultas();
    $resultado = $consultas->actualizarEstadoPedido($idpedido, $estado);

    if ($resultado) {
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
        'message' => 'Método no permitido'
    ]);
} 