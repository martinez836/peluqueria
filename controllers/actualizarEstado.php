<?php
session_start();
require_once '../models/consultas.php';
$consultas = new consultas();

if(isset($_POST['idcita'])) {
    $idcita = intval($_POST['idcita']);
    // Aquí creas una función para actualizar el estado a confirmado
    $resultado = $consultas->confirmarCita($idcita);

    if($resultado) {
        echo json_encode(['success' => true, 'message' => 'Cita confirmada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al confirmar cita']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de cita no recibido']);
}