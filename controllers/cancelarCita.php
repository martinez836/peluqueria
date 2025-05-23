<?php
header('Content-Type: application/json');
require_once '../models/consultas.php';

if(isset($_POST['idcita'])) {
    $idcita = $_POST['idcita'];
    $consultas = new consultas();
    
    $resultado = $consultas->cancelarCita($idcita);
    
    if($resultado) {
        echo json_encode(['success' => true, 'message' => 'Cita cancelada exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al cancelar la cita']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de cita no proporcionado']);
} 