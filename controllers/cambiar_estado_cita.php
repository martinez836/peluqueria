<?php
require_once '../models/consultas.php';

// Verificar que se recibieron los datos necesarios
if (!isset($_POST['idcita']) || !isset($_POST['estado'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
    exit;
}

$idcita = $_POST['idcita'];
$estado = $_POST['estado'];

// Instanciar el modelo
$consultas = new consultas();

// Intentar cambiar el estado
try {
    $resultado = $consultas->cambiarEstadoCita($idcita, $estado);
    
    if ($resultado) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo cambiar el estado de la cita']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 