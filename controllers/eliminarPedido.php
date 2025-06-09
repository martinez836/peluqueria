<?php
header('Content-Type: application/json');
require_once '../models/consultas.php';

if (!isset($_POST['idPedido'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID de pedido no proporcionado'
    ]);
    exit;
}

$idPedido = $_POST['idPedido'];
$consultas = new consultas();

// Verificar que el pedido no esté entregado
$resultado = $consultas->traerDetallePedido($idPedido);
$pedido = mysqli_fetch_assoc($resultado);

if ($pedido && $pedido['estado'] === 'entregado') {
    echo json_encode([
        'success' => false,
        'message' => 'No se puede eliminar un pedido que ya ha sido entregado'
    ]);
    exit;
}

// Cambiar el estado del pedido a inactivo
$resultado = $consultas->cambiarEstadoPedido($idPedido, 'inactivo');

if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Pedido eliminado correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar el pedido'
    ]);
} 