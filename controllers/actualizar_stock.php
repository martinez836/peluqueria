<?php
require_once '../models/consultas.php';

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Obtener los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['productos']) || !is_array($data['productos'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

$consultas = new consultas();
$errores = [];

// Actualizar el stock para cada producto
foreach ($data['productos'] as $producto) {
    if (!isset($producto['id']) || !isset($producto['cantidad'])) {
        $errores[] = 'Datos de producto incompletos';
        continue;
    }

    $resultado = $consultas->actualizarStock($producto['id'], $producto['cantidad']);
    
    if (!$resultado) {
        $errores[] = "Error al actualizar el stock del producto {$producto['id']}";
    }
}

// Devolver respuesta
if (empty($errores)) {
    echo json_encode(['success' => true, 'message' => 'Stock actualizado correctamente']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'errors' => $errores]);
} 