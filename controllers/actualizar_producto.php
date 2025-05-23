<?php
require_once '../models/consultas.php';

header('Content-Type: application/json');

if (!isset($_POST['id']) || !isset($_POST['nombre']) || !isset($_POST['precio']) || !isset($_POST['stock'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
    exit;
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'] ?? '';
$precio = $_POST['precio'];
$stock = $_POST['stock'];

$consultas = new consultas();

// Manejar la subida de imagen si se proporcionó una nueva
$imagen = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagen_temporal = $_FILES['imagen']['tmp_name'];
    $nombre_imagen = $_FILES['imagen']['name'];
    $extension = pathinfo($nombre_imagen, PATHINFO_EXTENSION);
    $nombre_unico = uniqid() . '.' . $extension;
    $ruta_destino = '../assets/img/productos/' . $nombre_unico;

    if (move_uploaded_file($imagen_temporal, $ruta_destino)) {
        $imagen = $nombre_unico;
    }
}

$resultado = $consultas->actualizarProducto($id, $nombre, $descripcion, $precio, $stock, $imagen);

if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Producto actualizado correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al actualizar el producto'
    ]);
} 