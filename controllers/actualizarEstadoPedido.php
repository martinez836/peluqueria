<?php
header('Content-Type: application/json');
require_once '../models/consultas.php';

if (!isset($_POST['idpedido']) || !isset($_POST['estado'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos requeridos'
    ]);
    exit;
}

$idpedido = $_POST['idpedido'];
$estado = $_POST['estado'];
$consultas = new consultas();

// Verificar el estado actual del pedido
$resultado = $consultas->traerDetallePedido($idpedido);
$pedido = mysqli_fetch_assoc($resultado);

// Validar que no se pueda cancelar un pedido entregado
if ($pedido['estado'] === 'entregado' && $estado === 'cancelado') {
    echo json_encode([
        'success' => false,
        'message' => 'No se puede cancelar un pedido que ya ha sido entregado'
    ]);
    exit;
}

// Actualizar el estado del pedido
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