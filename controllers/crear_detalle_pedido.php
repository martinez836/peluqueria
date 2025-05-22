<?php
// Evitar que se muestre cualquier error en la salida
error_reporting(0);
ini_set('display_errors', 0);

// Asegurarnos de que la respuesta sea JSON
header('Content-Type: application/json');

require_once '../models/consultas.php';

try {
    // Verificar que la solicitud sea POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Obtener los datos del cuerpo de la solicitud
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
    }

    // Verificar que los datos necesarios estén presentes
    if (!isset($data['idPedido']) || !isset($data['idProducto']) || 
        !isset($data['cantidad']) || !isset($data['subTotal'])) {
        throw new Exception('Datos incompletos');
    }

    $idPedido = $data['idPedido'];
    $idProducto = $data['idProducto'];
    $cantidad = $data['cantidad'];
    $subTotal = $data['subTotal'];

    // Validar que los valores sean válidos
    if ($idPedido <= 0 || $idProducto <= 0 || $cantidad <= 0 || $subTotal <= 0) {
        throw new Exception('Valores inválidos en los datos');
    }

    // Crear el detalle del pedido
    $consultas = new consultas();
    $resultado = $consultas->agregarDetallePedido($idPedido, $idProducto, $cantidad, $subTotal);

    if (!$resultado) {
        throw new Exception('Error al crear el detalle del pedido en la base de datos');
    }

    echo json_encode([
        'success' => true,
        'message' => 'Detalle de pedido creado correctamente'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 