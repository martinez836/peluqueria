<?php
header('Content-Type: application/json');
require_once '../models/consultas.php';

if(isset($_POST['idcita'])) {
    $idcita = $_POST['idcita'];
    $consultas = new consultas();
    
    $resultado = $consultas->confirmarCita($idcita);
    
    if($resultado) {
        echo json_encode(['success' => true, 'message' => 'Cita confirmada exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al confirmar la cita']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de cita no proporcionado']);
} 