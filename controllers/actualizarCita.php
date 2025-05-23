<?php
header('Content-Type: application/json');
require_once '../models/consultas.php';

try {
    if (!isset($_POST['idcita']) || !isset($_POST['fecha']) || !isset($_POST['servicio']) || !isset($_POST['estado'])) {
        throw new Exception('Faltan datos requeridos');
    }

    $idcita = $_POST['idcita'];
    $fecha = $_POST['fecha'];
    $servicio = $_POST['servicio'];
    $estado = $_POST['estado'];

    $consultas = new consultas();
    $resultado = $consultas->actualizarCita($idcita, $fecha, $servicio, $estado);

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Cita actualizada correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar la cita'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 