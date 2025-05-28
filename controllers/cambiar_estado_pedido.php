<?php
header('Content-Type: application/json');
require_once '../models/consultas.php';

$consultas = new consultas();

// Obtener datos del POST
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || !isset($data['estado'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos requeridos'
    ]);
    exit;
}

$id = $data['id'];
$estado = $data['estado'];

$resultado = $consultas->cambiarEstadoPedido($id, $estado);

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