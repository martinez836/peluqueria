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
    if (!isset($data['total']) || !isset($data['documento'])) {
        throw new Exception('Datos incompletos');
    }

    $total = $data['total'];
    $documento = $data['documento'];

    if (empty($documento)) {
        throw new Exception('El documento no puede estar vacío');
    }

    // Crear el pedido
    $consultas = new consultas();
    $resultado = $consultas->agregarPedido($total, $documento);

    if (!$resultado) {
        throw new Exception('Error al crear el pedido en la base de datos');
    }

    // Obtener el ID del pedido recién creado
    $idPedido = $consultas->mysql->getConexion()->insert_id;
    
    echo json_encode([
        'success' => true,
        'message' => 'Pedido creado correctamente',
        'idPedido' => $idPedido
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 