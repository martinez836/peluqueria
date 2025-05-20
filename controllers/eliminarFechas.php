<?php
require_once '../models/consultas.php';

header("Content-Type: application/json"); // Configurar la respuesta como JSON

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['fechas'])) {
        $consultas = new Consultas();
        $resultado = $consultas->eliminarFechasDeshabilitadas($data['fechas']);

        echo json_encode(["success" => $resultado ? "Fechas habilitadas correctamente" : "Error al eliminar"]);
    } else {
        echo json_encode(["error" => "No se enviaron fechas para habilitar"]);
    }
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
