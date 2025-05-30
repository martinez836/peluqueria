<?php
header('Content-Type: application/json');
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION["documento"])) {
    echo json_encode(["status" => "error", "mensaje" => "Sesión no iniciada"]);
    exit;
}

require_once '../models/consultas.php';
$consulta = new consultas();

$entradaJson = file_get_contents("php://input");
$datos = json_decode($entradaJson, true);

if (!$datos || !is_array($datos)) {
    echo json_encode(["status" => "error", "mensaje" => "Datos de carrito inválidos"]);
    exit;
}

$productos = $datos['productos'];
$total = $datos['total'];
$documento = $_SESSION["documento"];

try {
    // Verificar stock disponible antes de crear el pedido
    foreach ($productos as $producto) {
        $productoInfo = $consulta->obtenerProductoPorId($producto['id']);
        if (!$productoInfo) {
            throw new Exception("Producto no encontrado");
        }
        if ($productoInfo['stock'] < $producto['cantidad']) {
            throw new Exception("Stock insuficiente para el producto: " . $productoInfo['nombre']);
        }
    }

    $resultado = $consulta->agregarPedido($total, $documento);
    if (!$resultado) {
        throw new Exception("Error al crear el pedido");
    }

    $resultId = $consulta->mysql->efectuarConsulta("select MAX(idpedidos) as Id from pedidos");
    if (!$resultId) {
        throw new Exception("Error al obtener el ID del pedido");
    }

    $rowId = mysqli_fetch_assoc($resultId);
    $idPedido = $rowId['Id'];

    foreach ($productos as $producto) {
        $id = $producto['id'];
        $cantidad = $producto['cantidad'];
        $subTotal = $producto['precio'] * $producto['cantidad'];

        // Agregar el detalle del pedido
        $resultadoDetalle = $consulta->agregarDetallePedido($idPedido, $id, $cantidad, $subTotal);
        if (!$resultadoDetalle) {
            throw new Exception("Error al agregar el detalle del pedido");
        }

        // Actualizar el stock del producto
        $resultadoStock = $consulta->actualizarStock($id, $cantidad);
        if (!$resultadoStock) {
            throw new Exception("Error al actualizar el stock del producto");
        }
    }

    echo json_encode([
        "status" => "ok", 
        "mensaje" => "Pedido registrado correctamente",
        "idPedido" => $idPedido
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "mensaje" => $e->getMessage()
    ]);
}
