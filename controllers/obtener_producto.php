<?php
require_once '../models/consultas.php';

header('Content-Type: application/json');

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    exit;
}

$id = $_POST['id'];
$consultas = new consultas();
$producto = $consultas->obtenerProductoPorId($id);

if ($producto) {
    echo json_encode([
        'success' => true,
        'producto' => $producto
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Producto no encontrado'
    ]);
} 