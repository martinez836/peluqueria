<?php
header('Content-Type: application/json');
require_once '../models/consultas.php';

if(isset($_POST['idcita'])) {
    $idcita = $_POST['idcita'];
    $consultas = new consultas();
    
    $resultado = $consultas->completarCita($idcita);
    
    if($resultado) {
        echo json_encode(['success' => true, 'message' => 'Cita completada exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al completar la cita']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de cita no proporcionado']);
} 